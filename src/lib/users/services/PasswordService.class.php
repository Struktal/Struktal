<?php

namespace app\users\services;

use \app\users\dto;
use \app\users\uc;

class PasswordService {
    public static function passwordEditCheck(dto\PasswordEditCheckInputDTO $input): dto\PasswordEditCheckOutputDTO {
        $useCase = new uc\PasswordEditCheckUC();
        return $useCase->execute($input);
    }
}
