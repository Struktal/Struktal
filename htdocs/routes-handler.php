<?php

// Project directory: The directory where the project is located in the filesystem
chdir("../");
const __APP_DIR__ = __DIR__ . "/..";

require_once(__APP_DIR__ . "/framework/framework.php");

session_start();

$loggedInUser = Auth::getLoggedInUser();
if($loggedInUser instanceof User) {
    Blade->setAuth($loggedInUser->getUsername(), $loggedInUser->getPermissionLevel());
}
unset($loggedInUser);

// Start the Router
$router = new Router();
$router->startRouter();
