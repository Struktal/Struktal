<?php

class SEO {
    private static ?string $description = null;
    private static bool $unlisted = false;

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

    /**
     * Hide the Page from Search Engines
     * @return void
     */
    public static function setUnlisted(): void {
        self::$unlisted = true;
    }

    /**
     * Get the Values for the Robots Meta Tag
     * @return array
     */
    public static function getRobots(): array {
        if(self::$unlisted) {
            return ["noindex", "nofollow"];
        } else {
            return Config::$SEO_SETTINGS["SEO_ROBOTS"];
        }
    }
}
