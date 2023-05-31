<?php

enum InfoMessageType {
    case INFO;
    case WARNING;
    case ERROR;
    case SUCCESS;

    /**
     * Get the Info Message Code
     * @return int
     */
    function getCode(): int {
        return match($this) {
            self::INFO => 0,
            self::WARNING => 1,
            self::ERROR => 2,
            self::SUCCESS => 3
        };
    }

    /**
     * Get the formatted Info Message Type
     * @return string
     */
    function getFormatted(): string {
        return match($this) {
            self::INFO => "info",
            self::WARNING => "warning",
            self::ERROR => "error",
            self::SUCCESS => "success"
        };
    }
}
