<?php

class InfoMessage {
    private static array $infoMessages = array();
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

    public static function getMessages(): array {
        if(array_key_exists("infoMessages", $_SESSION)) {
            $infoMessages = $_SESSION["infoMessages"];
            usort($infoMessages, array("InfoMessage", "compare"));
            unset($_SESSION["infoMessages"]);

            return $infoMessages;
        }

        return array();
    }

    public function getMessage(): string {
        return $this->message;
    }

    public function getType(): int {
        return $this->type;
    }

    private static function compare($a, $b) {
        return $b->getType() - $a->getType();
    }
}