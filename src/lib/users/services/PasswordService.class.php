<?php

namespace struktal\users\services;

use \struktal\users\dto;
use \struktal\users\uc;

class PasswordService {
    public static function passwordEditCheck(dto\PasswordEditCheckInputDTO $input): dto\PasswordEditCheckOutputDTO {
        $useCase = new uc\PasswordEditCheckUC();
        return $useCase->execute($input);
    }
}
