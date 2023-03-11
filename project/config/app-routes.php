<?php

function addRoute(string $method, string $route, string $routeTo, string $name): void {
    Router::addRoute($method, $route, __DIR__ . "/../htdocs/" . $routeTo, $name);
}

addRoute("GET", "/", "index.php", "index");
addRoute("GET|POST", "/404", "404.php", "404");
addRoute("GET|POST", "/400", "400.php", "400");
