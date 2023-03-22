<?php

class InfoMessage {
    public static int $TYPE_INFO = 0;
    public static int $TYPE_WARNING = 1;
    public static int $TYPE_ERROR = 2;
    public static int $TYPE_SUCCESS = 3;

    private string $message;
    private string $type;

    public function __construct(string $message, int $type) {
        $this->message = $message;
        $this->type = $type;

        if(array_key_exists("infoMessages", $_SESSION)) {
            $_SESSION["infoMessages"][] = $this;
        } else {
            $_SESSION["infoMessages"] = array($this);
        }
    }

    /**
     * Check whether there are Messages to display
     * @return bool
     */
    public static function hasMessages(): bool {
        if(array_key_exists("infoMessages", $_SESSION)) {
            return sizeof($_SESSION["infoMessages"]) > 0;
        }

        return false;
    }

    /**
     * Get all Messages and remove them from the Session
     * @return array
     */
    public static function getMessages(): array {
        if(array_key_exists("infoMessages", $_SESSION)) {
            $infoMessages = $_SESSION["infoMessages"];
            usort($infoMessages, array("InfoMessage", "compare"));
            unset($_SESSION["infoMessages"]);

            return $infoMessages;
        }

        return array();
    }

    /**
     * Get the Message
     * @return string
     */
    public function getMessage(): string {
        return $this->message;
    }

    /**
     * Get the Info Message Type
     * @return int
     */
    public function getType(): int {
        return $this->type;
    }

    /**
     * Get the Info Message Type as String
     * @return string
     */
    public function getTypeFormatted(): string {
        return match($this->getType()) {
            InfoMessage::$TYPE_INFO => "info",
            InfoMessage::$TYPE_WARNING => "warning",
            InfoMessage::$TYPE_ERROR => "error",
            InfoMessage::$TYPE_SUCCESS => "success",
            default => strval($this->getType()),
        };
    }

    /**
     * Compare the Importance of two Info Messages
     * @param $a
     * @param $b
     * @return mixed
     */
    private static function compare($a, $b) {
        return $b->getType() - $a->getType();
    }
}