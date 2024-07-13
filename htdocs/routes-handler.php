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

// Set UI language
$translationsPath = __APP_DIR__ . "/project/translations";
$defaultLanguage = "en_US";
if(isset($_SERVER["HTTP_ACCEPT_LANGUAGE"])) {
    $acceptedLanguages = explode(",", $_SERVER["HTTP_ACCEPT_LANGUAGE"]);
    // TODO: Implement language detection
}

setlocale(LC_ALL, "en_US");
bindtextdomain("messages", $translationsPath);
textdomain("messages");

// Start the router
$router = new Router();
$router->startRouter();
