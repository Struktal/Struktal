<?php

class IncorrectDTOException extends Exception {

    public function __construct($message = "The provided DTO is incorrect for this use case.", $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
