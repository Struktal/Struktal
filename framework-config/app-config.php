<?php

// Project Settings
Config::$PROJECT_SETTINGS["PROJECT_NAME"] = "Project";
Config::$PROJECT_SETTINGS["PROJECT_URL"] = "https://domain.com/";

// Log Settings
Config::$LOG_SETTINGS["LOG_DIRECTORY"] = __DIR__ . "/../logs/";
Config::$LOG_SETTINGS["LOG_FILENAME"] = "log-%date%.log";
Config::$LOG_SETTINGS["LOG_LEVEL"] = 2;

// Database Settings
Config::$DB_SETTINGS["DB_HOST"] = "localhost";
Config::$DB_SETTINGS["DB_USER"] = "username";
Config::$DB_SETTINGS["DB_PASS"] = "password";
Config::$DB_SETTINGS["DB_NAME"] = "database";

// Mail Settings
Config::$MAIL_SETTINGS["MAIL_DEFAULT_SENDER_EMAIL"] = "mail@framework";
Config::$MAIL_SETTINGS["MAIL_DEFAULT_SENDER_NAME"] = "Framework";
Config::$MAIL_SETTINGS["MAIL_DEFAULT_REPLY_TO"] = "mail@framework";
Config::$MAIL_SETTINGS["MAIL_DEFAULT_SUBJECT"] = "Subject";
Config::$MAIL_SETTINGS["MAIL_REDIRECT_ALL_MAILS"] = false;
Config::$MAIL_SETTINGS["MAIL_REDIRECT_ALL_MAILS_TO"] = "mail@framework";

// Other Settings that shouldn't be published
include_once(__DIR__ . "/app-config.inc.php");