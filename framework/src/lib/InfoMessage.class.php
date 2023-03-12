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

        self::$infoMessages[] = $this;
    }

    public static function getMessages() {
        $infoMessages = self::$infoMessages;
        $infoMessages = usort($infoMessages, "compare");
        self::$infoMessages = array();
        return $infoMessages;
    }

    public function getMessage() {
        return $this->message;
    }

    public function getType() {
        return $this->type;
    }

    private function compare($a, $b) {
        return $a->getType() - $b->getType();
    }
}