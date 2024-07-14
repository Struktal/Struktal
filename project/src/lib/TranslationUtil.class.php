<?php

class TranslationUtil {
    const TRANSLATIONS_PATH = __APP_DIR__ . "/project/translations";

    /**
     * Returns the users preferred locale
     * @return string
     */
    public static function getPreferredLocale(): string {
        $acceptedLanguages = [];
        if(isset($_SERVER["HTTP_ACCEPT_LANGUAGE"])) {
            $headerParts = explode(",", $_SERVER["HTTP_ACCEPT_LANGUAGE"]);
            foreach($headerParts as $part) {
                $languageParts = explode(";", $part);
                $weight = 1;
                if(isset($languageParts[1])) {
                    $weight = intval(ltrim($languageParts[1], "q="));
                }

                $acceptedLanguages[$languageParts[0]] = $weight;
            }
        }

        $existingLanguages = self::getAvailableLocales();

        arsort($acceptedLanguages);
        foreach($acceptedLanguages as $language => $weight) {
            if(in_array($language, $existingLanguages)) {
                return $language;
            }
        }

        // Fallback
        return "en_US";
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
