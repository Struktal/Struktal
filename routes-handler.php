<?php

require_once(__DIR__ . "/framework/framework.php");

// Start the Router and pass this Projects Root Directory as Base Directory
$router = new Router();
$projectRootDirectory = str_replace("routes-handler.php", "", $_SERVER["SCRIPT_NAME"]);
$router->startRouter($projectRootDirectory);