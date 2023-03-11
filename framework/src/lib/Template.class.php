<?php

class Template {
    public static function loadTemplate($template) {
        $file = __PROJECT_DIR__ . "project/htdocs/frontend/" . $template;
        if(file_exists($file)) {
            include_once($file);
        } else {
            Logger::getLogger("Template")->error("Could not find Template File \"{$file}\".");
        }
    }

    public static function includeTemplate($template) {
        $file = __PROJECT_DIR__ . "project/htdocs/frontend/includes/" . $template;
        if(file_exists($file)) {
            include_once($file);
        } else {
            Logger::getLogger("Template")->error("Could not find Template File \"{$file}\".");
        }
    }
}
