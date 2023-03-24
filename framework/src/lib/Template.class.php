<?php

class Template {
    private static string $websiteTitle = "";
    /**
     * Include a PHP Template File that contains the frontend Code
     * @param string $template Name of Template File within the frontend Directory
     * @return void
     */
    public static function loadTemplate(string $template): void {
        $file = __PROJECT_DIR__ . "project/htdocs/frontend/" . $template;
        if(file_exists($file)) {
            include_once($file);
        } else {
            Logger::getLogger("Template")->error("Could not find Template File \"{$file}\".");
        }
    }

    /**
     * Include a PHP Template File within another Template File
     * @param string $template Name of Template File within the frontend/includes Directory
     * @return void
     */
    public static function includeTemplate(string $template): void {
        $file = __PROJECT_DIR__ . "project/htdocs/frontend/includes/" . $template;
        if(file_exists($file)) {
            include_once($file);
        } else {
            Logger::getLogger("Template")->error("Could not find Template File \"{$file}\".");
        }
    }

    /**
     * Set the Website Title with the Website Title defined in the Config as Suffix
     * @param string $title Website Title
     * @return void
     */
    public static function setWebsiteTitle(string $title): void {
        self::$websiteTitle = $title . " - " . Config::$PROJECT_SETTINGS["WEBSITE_TITLE"];
    }

    /**
     * Set the Website Title without the Website Title defined in the Config
     * @param string $title
     * @return void
     */
    public static function overrideWebsiteTitle(string $title): void {
        self::$websiteTitle = $title;
    }

    /**
     * Get the Website Title
     * @return string
     */
    public static function getWebsiteTitle(): string {
        return self::$websiteTitle;
    }
}
