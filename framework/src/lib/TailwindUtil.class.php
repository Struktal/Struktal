<?php

class TailwindUtil {
    // **********
    // Inputs
    // **********
    public static function inputGroup(bool $inline = false): string {
        $class = "w-full";
        if($inline) {
            $class .= " flex items-center gap-1";
        }
        return $class;
    }
    public static string $inputLabel = "text-sm font-bold data-[required]:after:content-['*'] data-[required]:after:text-primary";
    public static string $input = "w-full px-2 py-1 bg-background border border-gray outline-primary rounded placeholder:text-font-light";
    public static string $checkbox = "px-2 py-1 bg-background border border-gray outline-primary rounded placeholder:text-font-light";
    public static string $radio = "px-2 py-1 bg-background border border-gray outline-primary rounded placeholder:text-font-light";
    public static string $textarea = "w-full px-2 py-1 bg-background border border-gray outline-primary rounded placeholder:text-font-light";
    public static string $select = "w-full px-2 py-1 bg-background border border-gray outline-primary rounded placeholder:text-font-light";
    public static function button(bool $flat = false, string $theme = "primary"): string {
        $class = "inline-flex justify-around border rounded transition-all ";
        if($flat) {
            $class .= "px-2 py-1 ";
        } else {
            $class .= "px-4 py-2 ";
        }
        if($theme === "primary") {
            $class .= "text-primary-font bg-primary border-primary outline-primary hover:bg-primary-effect hover:border-primary-effect";
        } else if($theme === "secondary") {
            $class .= "text-secondary-font bg-secondary border-secondary outline-secondary hover:bg-secondary-effect hover:border-secondary-effect";
        } else if($theme === "gray") {
            $class .= "text-gray-font bg-gray border-gray outline-gray hover:bg-gray-effect hover:border-gray-effect";
        }
        return $class;
    }
}
