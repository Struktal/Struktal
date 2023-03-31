<?php

/**
 * Register a Route
 * @param string $method HTTP Method
 *                       Multiple Methods can be separated with a Pipe (|) Character, without Spaces or other Symbols
 * @param string $route Route that is expected to get called
 *                      GET Parameters can be added to the Route by using the following Syntax: {type:name}
 *                      Supported Types are b (Boolean), d (Date (without Time)), f (Float), i (Integer) and s (String)
 *                      Names are used to identify the Parameter within the $_GET Array
 * @param string $routeTo File within the project/htdocs/ Directory that should be opened when the Route is called
 * @param string $name Name of the Route
 * @return void
 */
function addRoute(string $method, string $route, string $routeTo, string $name): void {
    Router::addRoute($method, $route, __DIR__ . "/../htdocs/" . $routeTo, $name);
}

addRoute("GET", "/", "index.php", "index");
addRoute("GET|POST", "/404", "404.php", "404");
addRoute("GET|POST", "/400", "400.php", "400");
