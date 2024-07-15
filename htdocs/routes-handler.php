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
setlocale(LC_ALL, TranslationUtil::getPreferredLocale());
bindtextdomain("messages", TranslationUtil::TRANSLATIONS_PATH);
textdomain("messages");

// Start the router
$router = new Router();
$router->startRouter();
