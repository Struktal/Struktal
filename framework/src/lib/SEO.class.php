<?php

class SEO {
    private static ?string $description = null;

    /**
     * Set the Website Description
     * @param string $description
     * @return void
     */
    public static function setDescription(string $description): void {
        self::$description = $description;
    }

    /**
     * Get the Website Description
     * @return string
     */
    public static function getDescription(): string {
        if(self::$description !== null) {
            return self::$description;
        } else {
            return Config::$SEO_SETTINGS["SEO_DEFAULT_DESCRIPTION"];
        }
    }
}
