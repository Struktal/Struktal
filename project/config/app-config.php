<?php

// Project Settings
Config::$PROJECT_SETTINGS["PROJECT_NAME"] = "Project";
Config::$PROJECT_SETTINGS["PROJECT_URL"] = "https://domain.com/";
Config::$PROJECT_SETTINGS["PROJECT_AUTHOR"] = "Author";
Config::$PROJECT_SETTINGS["PROJECT_VERSION"] = "1.0.0";

// Menu Settings
Config::$MENU_SETTINGS["MENU_SIDEBAR"] = array(
    "Home" => array(
        "route" => Router::generate("index")
    )
);

// Time Format Settings
Config::$DATETIME_SETTINGS["DATE_TECHNICAL"] = "Y-m-d";
Config::$DATETIME_SETTINGS["TIME_TECHNICAL"] = "H:i:s";
Config::$DATETIME_SETTINGS["DATETIME_TECHNICAL"] = "Y-m-d H:i:s";
Config::$DATETIME_SETTINGS["DATE_VISUAL"] = "d.m.Y";
Config::$DATETIME_SETTINGS["TIME_VISUAL"] = "H:i";
Config::$DATETIME_SETTINGS["DATETIME_VISUAL"] = "d.m.Y H:i";

// Log Settings
Config::$LOG_SETTINGS["LOG_DIRECTORY"] = __DIR__ . "/../../logs/";
Config::$LOG_SETTINGS["LOG_FILENAME"] = "log-%date%.log";
Config::$LOG_SETTINGS["LOG_LEVEL"] = Logger::$LOG_INFO;

// Database Settings
Config::$DB_SETTINGS["DB_HOST"] = "localhost";
Config::$DB_SETTINGS["DB_USER"] = "username";
Config::$DB_SETTINGS["DB_PASS"] = "password";
Config::$DB_SETTINGS["DB_NAME"] = "database";
Config::$DB_SETTINGS["DB_USE"] = true;

// Mail Settings
Config::$MAIL_SETTINGS["MAIL_DEFAULT_SENDER_EMAIL"] = "mail@framework";
Config::$MAIL_SETTINGS["MAIL_DEFAULT_SENDER_NAME"] = "Framework";
Config::$MAIL_SETTINGS["MAIL_DEFAULT_REPLY_TO"] = "mail@framework";
Config::$MAIL_SETTINGS["MAIL_DEFAULT_SUBJECT"] = "Subject";
Config::$MAIL_SETTINGS["MAIL_REDIRECT_ALL_MAILS"] = false;
Config::$MAIL_SETTINGS["MAIL_REDIRECT_ALL_MAILS_TO"] = "mail@framework";

// Class Loader Settings
Config::$CLASS_LOADER_SETTINGS["CLASS_LOADER_IGNORE_FILES"][] = "Config.class.php";
Config::$CLASS_LOADER_SETTINGS["CLASS_LOADER_IGNORE_FILES"][] = "Logger.class.php";
Config::$CLASS_LOADER_SETTINGS["CLASS_LOADER_IGNORE_FILES"][] = "ClassLoader.class.php";
Config::$CLASS_LOADER_SETTINGS["CLASS_LOADER_IMPORT_PATHS"][] = __DIR__ . "/../src/lib/";
Config::$CLASS_LOADER_SETTINGS["CLASS_LOADER_IMPORT_PATHS"][] = __DIR__ . "/../src/object/";
Config::$CLASS_LOADER_SETTINGS["CLASS_LOADER_IMPORT_PATHS"][] = __DIR__ . "/../src/dao/";

// Other Settings that shouldn't be published
include_once(__DIR__ . "/app-config.inc.php");