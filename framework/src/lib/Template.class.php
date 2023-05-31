<?php

class Template {
    private static string $websiteTitle = "";

    /**
     * Include a PHP Template File that contains the frontend Code
     * @param string $template Name of Template File within the frontend Directory
     * @param array|null $variables Variables that should be available within the Template File
     * @return void
     */
    public static function display(string $template, ?array $variables = null): void {
        $file = __PROJECT_DIR__ . "project/htdocs/frontend/" . $template;
        if(file_exists($file)) {
            if(isset($variables) && $variables != null) {
                extract($variables);
            }

            include($file);
        } else {
            Logger::getLogger("Template")->error("Could not find Template File \"{$file}\".");
        }
    }

    /**
     * Include a PHP Template File within another Template File
     * @param string $template Name of Template File within the frontend/includes Directory
     * @param array|null $variables Variables that should be available within the Template File
     * @return void
     */
    public static function include(string $template, ?array $variables = null): void {
        $file = __PROJECT_DIR__ . "project/htdocs/frontend/includes/" . $template;
        if(file_exists($file)) {
            if(isset($variables) && $variables != null) {
                extract($variables);
            }

            include($file);
        } else {
            Logger::getLogger("Template")->error("Could not find Template File \"{$file}\".");
        }
    }

    /**
     * Fetch the HTML Code of a PHP Template File that contains the frontend Code
     * @param string $template
     * @param array|null $variables
     * @return string
     */
    public static function fetch(string $template, ?array $variables = null): string {
        ob_start();
        self::display($template, $variables);
        return ob_get_clean();
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
