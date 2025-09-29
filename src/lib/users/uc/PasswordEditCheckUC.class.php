<?php

namespace app\users\uc;

use \app\users\dto;
use \app\users\exceptions;

class PasswordEditCheckUC implements \UC {
    public function execute(\DTO $input): dto\PasswordEditCheckOutputDTO {
        if(!($input instanceof dto\PasswordEditCheckInputDTO)) {
            throw new \IncorrectDTOException();
        }

        $output = new dto\PasswordEditCheckOutputDTO();

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
