<?php

namespace struktal\users\validations;

class Validations {
    public static function username() {
        return Validation->create()
            ->string()
            ->minLength(5)
            ->maxLength(256)
            ->build();
    }

    public static function password() {
        return Validation->create()
            ->string()
            ->minLength(8)
            ->maxLength(256)
            ->build();
    }
}
