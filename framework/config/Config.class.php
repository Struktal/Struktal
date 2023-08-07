<?php

class Config {
    // Project Settings
    public static array $PROJECT_SETTINGS;

    // Menu Settings
    public static array $MENU_SETTINGS;

    // DateTime Format Settings
    public static array $DATETIME_SETTINGS;

    // Log Settings
    public static array $LOG_SETTINGS;

    // Database Settings
    public static array $DB_SETTINGS;

    // Mail Settings
    public static array $MAIL_SETTINGS;

    // Class Loader Settings
    public static array $CLASS_LOADER_SETTINGS;

    // SEO Settings
    public static array $SEO_SETTINGS;

    /**
     * Stores some Placeholder Config Values
     * They are overridden by root/project/config/app-config.php
     */
    public static function init(): void {
        self::$PROJECT_SETTINGS = [
            "PROJECT_NAME" => "Project",
            "WEBSITE_TITLE" => "Project",
            "PROJECT_URL" => "https://domain.com",
            "PROJECT_FAVICON" => Router::staticFilePath("img/favicon.png"),
            "PROJECT_AUTHOR" => "Author",
            "PROJECT_VERSION" => "1.0.0"
        ];

        self::$MENU_SETTINGS = [
            "MENU_SIDEBAR" => []
        ];

        self::$DATETIME_SETTINGS = [
            "DATE_TECHNICAL" => "Y-m-d",
            "TIME_TECHNICAL" => "H:i:s",
            "DATETIME_TECHNICAL" => "Y-m-d H:i:s",
            "DATE_VISUAL" => "d.m.Y",
            "TIME_VISUAL" => "H:i",
            "DATETIME_VISUAL" => "d.m.Y H:i"
        ];

        self::$LOG_SETTINGS = [
            "LOG_DIRECTORY" => __DIR__ . "/../../logs/",
            "LOG_FILENAME" => "log-%date%.log",
            "LOG_LEVEL" => Logger::$LOG_INFO
        ];

        self::$DB_SETTINGS = [
            "DB_HOST" => "localhost",
            "DB_USER" => "username",
            "DB_PASS" => "password",
            "DB_NAME" => "database",
            "DB_USE" => true
        ];

        self::$MAIL_SETTINGS = [
            "MAIL_DEFAULT_SENDER_EMAIL" => "mail@framework",
            "MAIL_DEFAULT_SENDER_NAME" => "Framework",
            "MAIL_DEFAULT_REPLY_TO" => "reply@framework",
            "MAIL_DEFAULT_SUBJECT" => "Framework Mail",
            "MAIL_REDIRECT_ALL_MAILS" => false,
            "MAIL_REDIRECT_ALL_MAILS_TO" => "redirect@framework"
        ];

        self::$CLASS_LOADER_SETTINGS = [
            "CLASS_LOADER_IGNORE_FILES" => [],
            "CLASS_LOADER_IMPORT_PATHS" => []
        ];

        self::$SEO_SETTINGS = [
            "SEO_DEFAULT_DESCRIPTION" => "Default Description",
            "SEO_KEYWORDS" => [],
            "SEO_IMAGE_PREVIEW" => Router::staticFilePath("img/seo/preview.png"),
            "SEO_OPENGRAPH" => [
                "OPENGRAPH_SITE_NAME" => null,
            ],
            "SEO_TWITTER" => [
                "TWITTER_SITE" => null,
                "TWITTER_CREATOR" => null
            ],
            "SEO_ROBOTS" => [
                "index", "follow"
            ],
            "SEO_REVISIT" => "1 days"
        ];
    }

    private function __construct() {
    }
}
