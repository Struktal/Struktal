<?php

// Project Directory: The Directory where the Project is located in the Filesystem
define("__PROJECT_DIR__", __DIR__ . "/");
// Server Directory: The Subdirectory that is passed in the URI to access the Project
$serverDirectory = str_replace("routes-handler.php", "", $_SERVER["SCRIPT_NAME"]);
define("__SERVER_DIR__", $serverDirectory);

require_once(__DIR__ . "/framework/framework.php");

session_start();

// Start the Router
$router = new Router();
$router->startRouter();