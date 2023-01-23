<?php

// Configuration Files
require_once(__DIR__ . "/config/Config.class.php");
Config::init();
require_once(__DIR__ . "/../framework-config/app-config.php");

// Libraries
require_once(__DIR__ . "/lib/Logger.class.php");