<?php

class Router {
    private static array $routes = array();

    /**
     * Adds a Route to the Registry
     * @param string $method HTTP Method
     *                       Multiple Methods can be separated with a Pipe (|) Character, without Spaces or other Symbols
     * @param string $route Route that is expected to get called
     *                      GET Parameters can be added to the Route by using the following Syntax: {type:name}
     *                      Supported Types are b (Boolean), d (Date (without Time)), f (Float), i (Integer) and s (String)
     *                      Names are used to identify the Parameter within the $_GET Array
     * @param string $routeTo File that should be opened when the Route is called
     * @param string $name Name of the Route
     * @return void
     */
    public static function addRoute(string $method = "GET|POST", string $route, string $routeTo, string $name) {
        $params = array();
        preg_match_all("/\{([bdfis]:[a-zA-Z0-9]+)\}/", $route, $matches);
        foreach($matches[1] as $match) {
            $paramType = explode(":", $match)[0];
            $paramName = str_replace($paramType . ":", "", $match);
            $params[$paramName] = $paramType;
        }

        $methods = explode("|", $method);
        foreach($methods as $method) {
            self::$routes[$method][$route] = array(
                "route" => $route,
                "routeTo" => $routeTo,
                "name" => $name,
                "params" => $params
            );
        }
    }

    /**
     * Generates the URI of the requested Route
     * @param string $name Name of the Route
     * @param array $params GET Parameters that should be added to the URI
     * @return string Route
     */
    public static function generate(string $name, array $params = array()): string {
        foreach(self::$routes as $method => $routes) {
            foreach($routes as $route => $routeData) {
                if($routeData["name"] == $name) {
                    // Found the Route
                    $requiredParams = array_keys($routeData["params"]);
                    foreach($params as $paramName => $paramValue) {
                        if(isset($routeData["params"][$paramName])) {
                            if($routeData["params"][$paramName] == "b" && is_bool($paramValue)) {
                                $paramValue = $paramValue ? "true" : "false";
                                $route = str_replace("{" . $routeData["params"][$paramName] . ":" . $paramName . "}", $paramValue, $route);
                                $requiredParams = array_diff($requiredParams, array($paramName));
                            } else if($routeData["params"][$paramName] == "d" && (DateTime::createFromFormat(Config::$DATETIME_SETTINGS["DATE_TECHNICAL"], $paramValue) !== false || $paramValue instanceof DateTime)) {
                                if($paramValue instanceof DateTime) {
                                    $paramValue = DateFormatter::technicalDate($paramValue);
                                }

                                $route = str_replace("{" . $routeData["params"][$paramName] . ":" . $paramName . "}", $paramValue, $route);
                                $requiredParams = array_diff($requiredParams, array($paramName));
                            } else if($routeData["params"][$paramName] == "f" && is_float($paramValue)) {
                                $paramValue = floatval($paramValue);
                                $route = str_replace("{" . $routeData["params"][$paramName] . ":" . $paramName . "}", $paramValue, $route);
                                $requiredParams = array_diff($requiredParams, array($paramName));
                            } else if($routeData["params"][$paramName] == "i" && is_int($paramValue)) {
                                $paramValue = intval($paramValue);
                                $route = str_replace("{" . $routeData["params"][$paramName] . ":" . $paramName . "}", $paramValue, $route);
                                $requiredParams = array_diff($requiredParams, array($paramName));
                            } else if($routeData["params"][$paramName] == "s" && is_string($paramValue)) {
                                $paramValue = strval($paramValue);
                                $route = str_replace("{" . $routeData["params"][$paramName] . ":" . $paramName . "}", $paramValue, $route);
                                $requiredParams = array_diff($requiredParams, array($paramName));
                            }
                        }
                    }

                    if(sizeof($requiredParams) == 0) {
                        return __SERVER_DIR__ . ltrim($route, "/");
                    }
                }
            }
        }

        return __SERVER_DIR__;
    }

    /**
     * Starts the Router
     * @return void
     */
    public function startRouter(): void {
        $method = $_SERVER["REQUEST_METHOD"];
        $uri = $_SERVER["REQUEST_URI"];
        $uri = explode("?", $uri)[0];
        if(str_starts_with($uri, __SERVER_DIR__)) {
            $uri = substr($uri, strlen(__SERVER_DIR__));
        }
        $uri = trim($uri, "/");

        $foundRoute = array();
        $foundRouteDepth = 0;
        foreach(self::$routes[$method] as $routeData) {
            $route = $routeData["route"];
            $route = trim($route, "/");
            $regex = "";
            $routeParts = explode("/", $route);
            if(sizeof($routeParts) >= $foundRouteDepth) {
                // Create regular Expression for the current Route
                foreach($routeParts as $part) {
                    if(preg_match("/\{([bdfis]:[a-zA-Z0-9]+)\}/", $part)) {
                        // Is Parameter
                        $part = trim($part, "{}");
                        $paramType = explode(":", $part)[0];
                        switch($paramType) {
                            case "b":
                                $regex .= "[true|false]\/";
                                break;
                            case "d":
                                $regex .= DateFormatter::technicalDateRegex() . "\/";
                                break;
                            case "f":
                                $regex .= "[\d]+(\.[\d]+)?\/";
                                break;
                            case "i":
                                $regex .= "[\d]+\/";
                                break;
                            case "s":
                                $regex .= ".+\/";
                                break;
                        }
                    } else {
                        // Is no Parameter
                        $regex .= $part . "\/";
                    }
                }
                if(str_ends_with($regex, "\/")) {
                    $regex = substr($regex, 0, strlen($regex) - 2);
                }

                if(preg_match("#" . $regex . "#", $uri)) {
                    // The current Route matches the Request
                    $foundRoute = $routeData;
                    $foundRouteDepth = sizeof($routeParts);
                }
            }
        }

        if(!(array_key_exists("route", $foundRoute))) {
            Comm::redirect(Router::generate("404"));
            http_response_code(404);
            return;
        }

        $route = $foundRoute["route"];
        $route = trim($route, "/");
        $routeTo = $foundRoute["routeTo"];

        // Set GET Parameters
        foreach(explode("/", $route) as $key => $part) {
            if(preg_match("/\{([bdfis]:[a-zA-Z0-9]+)\}/", $part)) {
                $part = trim($part, "{}");
                $paramType = explode(":", $part)[0];
                $paramName = str_replace($paramType . ":", "", $part);
                $paramValue = explode("/", $uri)[$key];

                switch($paramType) {
                    case "b":
                        if(filter_var($paramValue, FILTER_VALIDATE_BOOLEAN)) {
                            $paramValue = boolval($paramValue);
                        } else {
                            Comm::redirect(Router::generate("400"));
                            http_response_code(400);
                            return;
                        }
                        break;
                    case "d":
                        if(DateTime::createFromFormat(Config::$DATETIME_SETTINGS["DATE_TECHNICAL"], $paramValue) !== false) {
                            $paramValue = strval($paramValue);
                        } else {
                            Comm::redirect(Router::generate("400"));
                            http_response_code(400);
                            return;
                        }
                        break;
                    case "f":
                        if(filter_Var($paramValue, FILTER_VALIDATE_FLOAT)) {
                            $paramValue = floatval($paramValue);
                        } else {
                            Comm::redirect(Router::generate("400"));
                            http_response_code(400);
                            return;
                        }
                        break;
                    case "i":
                        if(filter_var($paramValue, FILTER_VALIDATE_INT)) {
                            $paramValue = intval($paramValue);
                        } else {
                            Comm::redirect(Router::generate("400"));
                            http_response_code(400);
                            return;
                        }
                        break;
                    case "s":
                        $paramValue = strval($paramValue);
                        break;
                }

                $_GET[$paramName] = urldecode($paramValue);
            }
        }

        if(str_ends_with($routeTo, ".php")) {
            if(file_exists($routeTo)) {
                include_once($routeTo);
            } else {
                Comm::redirect(self::generate("404"));
                http_response_code(404);
                Logger::getLogger("Router")->error("Could not find File \"{$routeTo}\" for Route \"{$route}\"");
            }
        } else {
            if(file_exists($routeTo)) {
                $this->sendContentTypeHeader($routeTo);
                readfile($routeTo);
                exit;
            } else {
                Comm::redirect(self::generate("404"));
                http_response_code(404);
                Logger::getLogger("Router")->error("Could not find File \"{$routeTo}\" for Route \"{$route}\"");
            }
        }
    }
    
    /**
     * Generates the Import Path for a File in the Static Directory
     * @param string $file
     * @return string
     */
    public static function staticFilePath(string $file): string {
        return __SERVER_DIR__ . "static/" . trim($file, "/");
    }

    /**
     * Sends the correct Content-Type Header for a given File
     * @param $path
     * @return void
     */
    private function sendContentTypeHeader($path): void {
        $extensions = array(
            "html" => "text/html",
            "css" => "text/css",
            "js" => "text/javascript",
            "json" => "application/json",
            "xml" => "application/xml",
            "png" => "image/png",
            "jpg" => "image/jpeg",
            "jpeg" => "image/jpeg",
            "gif" => "image/gif",
            "svg" => "image/svg+xml",
            "ico" => "image/x-icon",
            "ttf" => "font/ttf",
            "otf" => "font/otf",
            "woff" => "font/woff",
            "woff2" => "font/woff2",
            "eot" => "font/eot",
            "pdf" => "application/pdf",
            "zip" => "application/zip",
            "rar" => "application/x-rar-compressed",
            "7z" => "application/x-7z-compressed",
            "mp3" => "audio/mpeg",
            "wav" => "audio/wav",
            "ogg" => "audio/ogg",
            "mp4" => "video/mp4",
            "webm" => "video/webm",
            "avi" => "video/x-msvideo",
            "mpg" => "video/mpeg",
            "mpeg" => "video/mpeg",
            "flv" => "video/x-flv",
            "swf" => "application/x-shockwave-flash",
            "txt" => "text/plain",
            "csv" => "text/csv",
            "ics" => "text/calendar",
            "rtf" => "application/rtf",
            "doc" => "application/msword",
            "docx" => "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
            "xls" => "application/vnd.ms-excel",
            "xlsx" => "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
            "ppt" => "application/vnd.ms-powerpoint",
            "pptx" => "application/vnd.openxmlformats-officedocument.presentationml.presentation"
        );

        foreach($extensions as $extension => $contentType) {
            if(str_ends_with($path, "." . $extension)) {
                header("Content-Type: $contentType");
                return;
            }
        }
    }
}