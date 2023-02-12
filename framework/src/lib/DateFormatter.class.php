<?php

class DateFormatter {
    /**
     * Creates a regular Expression to the given DateTime Format
     * @param string $format
     * @return string
     */
    private static function createRegex(string $format): string {
        $format = str_replace("Y", "[0-9]{4}", $format);
        $format = str_replace("m", "[0-9]{2}", $format);
        $format = str_replace("d", "[0-9]{2}", $format);
        $format = str_replace("H", "[0-9]{2}", $format);
        $format = str_replace("i", "[0-9]{2}", $format);
        $format = str_replace("s", "[0-9]{2}", $format);
        return $format;
    }

    /**
     * Formats the given DateTime to the Technical Date Format
     * @param DateTime $dateTime
     * @return string
     */
    public static function technicalDate(DateTime $dateTime = new DateTime()): string {
        return $dateTime->format(Config::$DATETIME_SETTINGS["DATE_TECHNICAL"]);
    }

    /**
     * Returns the regular Expression for the Technical Date Format
     * @return string
     */
    public static function technicalDateRegex(): string {
        return self::createRegex(Config::$DATETIME_SETTINGS["DATE_TECHNICAL"]);
    }

    /**
     * Formats the given DateTime to the Technical Time Format
     * @param DateTime $dateTime
     * @return string
     */
    public static function technicalTime(DateTime $dateTime = new DateTime()): string {
        return $dateTime->format(Config::$DATETIME_SETTINGS["TIME_TECHNICAL"]);
    }

    /**
     * Formats the given DateTime to the Technical DateTime Format
     * @param DateTime $dateTime
     * @return string
     */
    public static function technicalDateTime(DateTime $dateTime = new DateTime()): string {
        return $dateTime->format(Config::$DATETIME_SETTINGS["DATETIME_TECHNICAL"]);
    }

    /**
     * Parses the given Technical DateTime String to a DateTime
     * @param string $dateTime
     * @return DateTime
     */
    public static function parseTechnicalDateTime(string $dateTime): DateTime {
        return DateTime::createFromFormat(Config::$DATETIME_SETTINGS["DATETIME_TECHNICAL"], $dateTime);
    }

    /**
     * Formats the given DateTime to the Visual Date Format
     * @param DateTime $dateTime
     * @return string
     */
    public static function visualDate(DateTime $dateTime = new DateTime()): string {
        return $dateTime->format(Config::$DATETIME_SETTINGS["DATE_VISUAL"]);
    }

    /**
     * Formats the given DateTime to the Visual Time Format
     * @param DateTime $dateTime
     * @return string
     */
    public static function visualTime(DateTime $dateTime = new DateTime()): string {
        return $dateTime->format(Config::$DATETIME_SETTINGS["TIME_VISUAL"]);
    }

    /**
     * Formats the given DateTime to the Visual DateTime Format
     * @param DateTime $dateTime
     * @return string
     */
    public static function visualDateTime(DateTime $dateTime = new DateTime()): string {
        return $dateTime->format(Config::$DATETIME_SETTINGS["DATETIME_VISUAL"]);
    }

    /**
     * Parses the given Visual DateTime String to a DateTime
     * @param string $dateTime
     * @return DateTime
     */
    public static function parseVisualDateTime(string $dateTime): DateTime {
        return DateTime::createFromFormat(Config::$DATETIME_SETTINGS["DATETIME_VISUAL"], $dateTime);
    }
}
