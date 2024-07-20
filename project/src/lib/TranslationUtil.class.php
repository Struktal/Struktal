<?php

class TranslationUtil {
    const TRANSLATIONS_PATH = __APP_DIR__ . "/project/translations";

    private static string $regex = "/[a-zA-Z]{1,8}(?:-[a-zA-Z]{1,8}){0,2}(?:;q=[0-9]+(?:\.[0-9]+)?)?/";

    /**
     * Returns the users preferred locale
     * @return string
     */
    public static function getPreferredLocale(): string {
        $preferredLocales = self::getPreferredLocalesFromHeader();
        $existingLanguages = self::getAvailableLocales();

        foreach($preferredLocales as $preferredLocale) {
            $language = $preferredLocale["language"];
            $script = $preferredLocale["script"];
            $region = $preferredLocale["region"];
            $regex = $language;
            if($script) {
                $regex .= "_" . $script;
            } else {
                $regex .= "(_[a-zA-Z]+)?";
            }
            if($region) {
                $regex .= "_" . $region;
            } else {
                $regex .= "(_[a-zA-Z]{2})?";
            }

            foreach($existingLanguages as $existingLanguage) {
                if(preg_match("/^$regex$/", $existingLanguage)) {
                    return $existingLanguage;
                }
            }
        }

        // Fallback
        return "en_US";
    }

    /**
     * Get a sorted list of preferred locales from the Accept-Language header
     * @return array
     */
    public static function getPreferredLocalesFromHeader(): array {
        $header = $_SERVER["HTTP_ACCEPT_LANGUAGE"] ?? "";
        $header = trim($header);

        // Match regex against header to extract the language parts
        preg_match_all(self::$regex, $header, $headerParts);
        $headerParts = $headerParts[0];

        // Interpret the language parts
        $preferredLocales = array_map(function(string $part) {
            if(!$part) {
                return null;
            }

            $bits = explode(";", $part);
            $localeTag = explode("-", $bits[0]);
            $hasRegion = count($localeTag) >= 2;
            $hasScript = count($localeTag) === 3;

            return [
                "code" => $bits[0],
                "priority" => count($bits) > 1 ? floatval(explode("=", $bits[1])[1]) : 1.0,
                "language" => $localeTag[0],
                "script" => $hasScript ? $localeTag[1] : null,
                "region" => $hasRegion ? $localeTag[$hasScript ? 2 : 1] : null
            ];
        }, $headerParts);

        // Filter out null values
        $preferredLocales = array_filter($preferredLocales, function($part) {
            return $part !== null;
        });

        // Sort locales by their priority
        usort($preferredLocales, function($a, $b) {
            return $b["priority"] <=> $a["priority"];
        });

        return $preferredLocales;
    }

    /**
     * Returns a list of available locales
     * @return array
     */
    public static function getAvailableLocales(): array {
        $directories = scandir(self::TRANSLATIONS_PATH);
        return array_filter($directories, function($directory) {
            return is_dir(self::TRANSLATIONS_PATH . "/" . $directory) && $directory !== "." && $directory !== "..";
        });
    }
}
