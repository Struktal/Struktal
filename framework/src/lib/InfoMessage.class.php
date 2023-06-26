<?php

class InfoMessage {
    private string $message;
    private InfoMessageType $type;

    public function __construct(string $message, InfoMessageType $type) {
        $this->message = $message;
        $this->type = $type;

        if(array_key_exists("infoMessages", $_SESSION)) {
            $_SESSION["infoMessages"][] = $this;
        } else {
            $_SESSION["infoMessages"] = [$this];
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
            usort($infoMessages, ["InfoMessage", "compare"]);
            unset($_SESSION["infoMessages"]);

            return $infoMessages;
        }

        return [];
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
     * @return InfoMessageType
     */
    public function getType(): InfoMessageType {
        return $this->type;
    }

    /**
     * Compare the Importance of two Info Messages
     * @param $a
     * @param $b
     * @return mixed
     */
    private static function compare($a, $b) {
        return $b->getType()->getCode() - $a->getType()->getCode();
    }
}
