<?php

// Configuration Files
require_once(__DIR__ . "/config/Config.class.php");
Config::init();
require_once(__DIR__ . "/../project/config/app-config.php");

// Class Loader
require_once(__DIR__ . "/src/ClassLoader.class.php");
$classLoader = ClassLoader::getInstance();

// Load Logger
$classLoader->loadClass(__DIR__ . "/src/Logger.class.php");

// Load Util
$classLoader->loadClass(__DIR__ . "/src/Util.class.php");

// Load Comm
$classLoader->loadClass(__DIR__ . "/src/Comm.class.php");

// Load Libraries
$classLoader->loadClasses(__DIR__ . "/src/lib/");

// Load Objects
$classLoader->loadClasses(__DIR__ . "/src/object/");

// Load DAOs
$classLoader->loadClasses(__DIR__ . "/src/dao/");

// Load Extra Classes
foreach(Config::$CLASS_LOADER_SETTINGS["CLASS_LOADER_IMPORT_PATHS"] as $path) {
    $classLoader->loadClasses($path);
}