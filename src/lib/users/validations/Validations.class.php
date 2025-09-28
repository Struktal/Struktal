<?php

namespace app\users\validations;

class Validations {
    public static function username(): \struktal\validation\internals\Validator {
        return Validation->create()
            ->string()
            ->minLength(5)
            ->maxLength(256)
            ->build();
    }

    public static function password(): \struktal\validation\internals\Validator {
        return Validation->create()
            ->string()
            ->minLength(8)
            ->maxLength(256)
            ->build();
    }

    public static function email(?string $errorMessage = null): \struktal\validation\internals\Validator {
        $validation = Validation->create()
            ->string()
            ->email();
        if($errorMessage !== null) {
            $validation->withErrorMessage($errorMessage);
        }
        return $validation->build();
    }

    public static function otp(): \struktal\validation\internals\Validator {
        return Validation->create()
            ->string()
            ->minLength(1)
            ->build();
    }

    public static function otpId(): \struktal\validation\internals\Validator {
        return Validation->create()
            ->string()
            ->minLength(1)
            ->build();
    }
}
