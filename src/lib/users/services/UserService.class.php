<?php

namespace app\users\services;

use \app\users\dto;
use \app\users\uc;

class UserService {
    public static function register(dto\RegisterInputDTO $input): dto\RegisterOutputDTO {
        $useCase = new uc\RegisterUC();
        return $useCase->execute($input);
    }

    public static function login(dto\LoginInputDTO $input): dto\LoginOutputDTO {
        $useCase = new uc\LoginUC();
        return $useCase->execute($input);
    }

    public static function logout(dto\LogoutInputDTO $input): dto\LogoutOutputDTO {
        $useCase = new uc\LogoutUC();
        return $useCase->execute($input);
    }

    public static function getLoggedInUser(dto\GetLoggedInUserInputDTO $input): dto\GetLoggedInUserOutputDTO {
        $useCase = new uc\GetLoggedInUserUC();
        return $useCase->execute($input);
    }
}
