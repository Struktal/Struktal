<?php

function addRoute(string $method, string $route, string $routeTo, string $name): void {
    Router::addRoute($method, $route, __DIR__ . "/../htdocs/" . $routeTo, $name);
}

addRoute("GET", "/", "test.php", "index");
addRoute("GET", "/ana", "ana2.pdf", "analysis");
