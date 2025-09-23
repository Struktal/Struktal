<?php

namespace struktal\users\uc;

use \struktal\users\dto;
use \struktal\users\exceptions;

class PasswordResetCheckUC implements \UC {
    public function execute(\DTO $input): dto\PasswordResetCheckOutputDTO {
        if(!($input instanceof dto\PasswordResetCheckInputDTO)) {
            throw new \IncorrectDTOException();
        }

        $output = new dto\PasswordResetCheckOutputDTO();

        $password = $input->password;
        $passwordRepeat = $input->passwordRepeat;

        // Check whether passwords match
        if($password !== $passwordRepeat) {
            throw new exceptions\PasswordMismatchException();
        }

        // Check password strength
        if(!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*[\d\W]).{8,}$/", $password)) {
            throw new exceptions\WeakPasswordException();
        }

        $output->password = $password;
        return $output;
    }
}
