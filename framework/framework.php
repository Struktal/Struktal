<?php

// Vendor Autoloader
require_once(__DIR__ . "/../project/src/lib/vendor/autoload.php");

// Setup Composer Libraries
use jensostertag\Templify\Templify;
Templify::setConfig("TEMPLATE_BASE_DIR", __DIR__ . "/../project/htdocs/frontend/");

// Class Loader
require_once(__DIR__ . "/src/ClassLoader.class.php");
$classLoader = ClassLoader::getInstance();

// Load Logger
$classLoader->loadClass(__DIR__ . "/src/Logger.class.php");

// Load Comm
$classLoader->loadClass(__DIR__ . "/src/Comm.class.php");

// Load Router and initialize Routes
$classLoader->loadClass(__DIR__ . "/src/Router.class.php");
require_once(__DIR__ . "/../project/config/app-routes.php");

// Configuration Files
require_once(__DIR__ . "/config/Config.class.php");
Config::init();
require_once(__DIR__ . "/../project/config/app-config.php");

// Load Enums
$classLoader->loadEnums(__DIR__ . "/src/enum/");

// Load Libraries
$classLoader->loadClasses(__DIR__ . "/src/lib/");
$classLoader->load(__DIR__ . "/src/lib/methods.php");

// Load Objects
$classLoader->loadClasses(__DIR__ . "/src/object/");

// Load DAOs
$classLoader->loadClasses(__DIR__ . "/src/dao/");

// Load Extra Classes
foreach(Config::$CLASS_LOADER_SETTINGS["CLASS_LOADER_IMPORT_PATHS"] as $path) {
    $classLoader->loadEnums($path);
    $classLoader->loadClasses($path);
}
