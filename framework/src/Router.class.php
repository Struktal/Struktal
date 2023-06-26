<?php

class Router {
    private static array $routes = [];

    /**
     * Register a Route
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
        // Retrieve Parameters from the Route
        $params = [];
        preg_match_all("/\{([bdfis]:[a-zA-Z0-9]+)\}/", $route, $matches);
        foreach($matches[1] as $match) {
            $paramType = explode(":", $match)[0];
            $paramName = str_replace($paramType . ":", "", $match);
            $params[$paramName] = $paramType;
        }

        // Save the Route in the Routes Array
        $methods = explode("|", $method);
        foreach($methods as $method) {
            self::$routes[$method][$route] = [
                "route" => $route,
                "routeTo" => $routeTo,
                "name" => $name,
                "params" => $params
            ];
        }
    }

    /**
     * Generate the URI for a Route
     * @param string $name Name of the Route
     * @param array $params GET Parameters that should be added to the URI
     * @return string Route
     */
    public static function generate(string $name, array $params = []): string {
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
                                $requiredParams = array_diff($requiredParams, [$paramName]);
                            } else if($routeData["params"][$paramName] == "d" && (DateTime::createFromFormat(Config::$DATETIME_SETTINGS["DATE_TECHNICAL"], $paramValue) !== false || $paramValue instanceof DateTime)) {
                                if($paramValue instanceof DateTime) {
                                    $paramValue = DateFormatter::technicalDate($paramValue);
                                }

                                $route = str_replace("{" . $routeData["params"][$paramName] . ":" . $paramName . "}", $paramValue, $route);
                                $requiredParams = array_diff($requiredParams, [$paramName]);
                            } else if($routeData["params"][$paramName] == "f" && is_float($paramValue)) {
                                $paramValue = floatval($paramValue);
                                $route = str_replace("{" . $routeData["params"][$paramName] . ":" . $paramName . "}", $paramValue, $route);
                                $requiredParams = array_diff($requiredParams, [$paramName]);
                            } else if($routeData["params"][$paramName] == "i" && is_int($paramValue)) {
                                $paramValue = intval($paramValue);
                                $route = str_replace("{" . $routeData["params"][$paramName] . ":" . $paramName . "}", $paramValue, $route);
                                $requiredParams = array_diff($requiredParams, [$paramName]);
                            } else if($routeData["params"][$paramName] == "s" && is_string($paramValue)) {
                                $paramValue = strval($paramValue);
                                $route = str_replace("{" . $routeData["params"][$paramName] . ":" . $paramName . "}", $paramValue, $route);
                                $requiredParams = array_diff($requiredParams, [$paramName]);
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
     * Redirect to the File that is registered for the requested Route
     * This Method also sets Values in the $_GET Array
     * If no Route is found or the File does not exist, the 404 Page will be opened
     * If the required Parameters are not valid, the 400 Page will be opened
     * @return void
     */
    public function startRouter(): void {
        $method = $_SERVER["REQUEST_METHOD"];
        $uri = $_SERVER["REQUEST_URI"];

        // Remove GET Parameters after a Question Mark
        // GET Parameters are set differently
        $uri = explode("?", $uri)[0];
        // Remove the Root Directory from the URI
        // This is required if the Project is not located in the Server's Root Directory
        if(str_starts_with($uri, __SERVER_DIR__)) {
            $uri = substr($uri, strlen(__SERVER_DIR__));
        }
        // Remove leading and trailing Slashes
        $uri = trim($uri, "/");

        $foundRoute = [];
        $routeFound = false;
        foreach(self::$routes[$method] as $routeData) {
            $route = $routeData["route"];
            $route = trim($route, "/");
            $regex = "";
            $routeParts = explode("/", $route);
            // Loop over all Parts of the Route and create a Regex
            foreach($routeParts as $part) {
                if(preg_match("/\{([bdfis]:[a-zA-Z0-9]+)\}/", $part)) {
                    // The current Route Part is a Parameter
                    // Add Regex for the corresponding Parameter Type
                    $part = trim($part, "{}");
                    $paramType = explode(":", $part)[0];
                    switch($paramType) {
                        case "b":
                            $regex .= "true|false\/";
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
                    // The current Route Part is no Parameter
                    // Simply add the Part to the Regex
                    $regex .= $part . "\/";
                }
            }
            if(str_ends_with($regex, "\/")) {
                $regex = substr($regex, 0, strlen($regex) - 2);
            }

            if(preg_match("#^" . $regex . "$#i", $uri)) {
                // The current Route matches the Request
                $foundRoute = $routeData;
                $routeFound = true;
            }
        }

        if(!($routeFound)) {
            Comm::redirect(Router::generate("404"));
            http_response_code(404);
            return;
        }

        $route = $foundRoute["route"];
        $route = trim($route, "/");
        $routeTo = $foundRoute["routeTo"];

        // Set the GET Parameters
        // Loop over all Parts of the Route
        foreach(explode("/", $route) as $key => $part) {
            if(preg_match("/\{([bdfis]:[a-zA-Z0-9]+)\}/", $part)) {
                // The current Route Part is a Parameter
                // Retrieve the Parameter Type and Name from the Route Part and the Value from the URI
                $part = trim($part, "{}");
                $paramType = explode(":", $part)[0];
                $paramName = str_replace($paramType . ":", "", $part);
                $paramValue = explode("/", $uri)[$key];

                if(self::getParameterFromString($paramValue, $paramType) !== null) {
                    $paramValue = self::getParameterFromString($paramValue, $paramType);
                } else {
                    Comm::redirect(Router::generate("400"));
                    http_response_code(400);
                    return;
                }

                $_GET[$paramName] = urldecode($paramValue);
            }
        }

        // Redirect to the File that is registered for the Route
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
     * Get the URL that was called
     * @return string
     */
    public static function getCalledURL(): string {
        return rtrim(Config::$PROJECT_SETTINGS["PROJECT_URL"], "/") . "/" . ltrim($_SERVER["REQUEST_URI"], "/");
    }
    
    /**
     * Generate the Import Path for a File within the Static Directory
     * @param string $path File Path
     * @return string
     */
    public static function staticFilePath(string $path): string {
        return __SERVER_DIR__ . "static/" . trim($path, "/");
    }

    /**
     * If Parsing is possible, get the Parameter of the corresponding Type from a String
     * @param mixed $value Value that should be parsed
     * @param string $parameter Type of the Parameter (b, d, f, i, s)
     * @return mixed|null Parsed Parameter or null if Parsing is not possible
     */
    private static function getParameterFromString(mixed $value, string $parameter): mixed {
        switch($parameter) {
            case "b":
                if(filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) !== null) {
                    return filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
                }
                break;
            case "d":
                if(DateTime::createFromFormat(Config::$DATETIME_SETTINGS["DATE_TECHNICAL"], $value) !== false) {
                    return strval($value);
                }
                break;
            case "f":
                if(filter_var($value, FILTER_VALIDATE_FLOAT)) {
                    return floatval($value);
                }
                break;
            case "i":
                if(filter_var($value, FILTER_VALIDATE_INT)) {
                    return intval($value);
                }
                break;
            case "s":
                return strval($value);
        }

        return null;
    }

    /**
     * Send the correct Content-Type Header for a given File
     * @param string $file File Name or Path
     * @return void
     */
    private function sendContentTypeHeader(string $file): void {
        $extensions = [
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
        ];

        foreach($extensions as $extension => $contentType) {
            if(str_ends_with($file, "." . $extension)) {
                header("Content-Type: $contentType");
                return;
            }
        }
    }
}
