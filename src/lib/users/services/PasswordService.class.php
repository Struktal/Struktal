<?php

namespace struktal\users\services;

use \struktal\users\dto;
use \struktal\users\uc;

class PasswordService {
    public static function passwordResetCheck(dto\PasswordResetCheckInputDTO $input): dto\PasswordResetCheckOutputDTO {
        $useCase = new uc\PasswordResetCheckUC();
        return $useCase->execute($input);
    }
}
