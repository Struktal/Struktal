<?php

namespace struktal\users\uc;

use \struktal\users\dto;
use \struktal\users\orm;
use \struktal\users\exceptions;

class LoginUC implements \UC {
    public function execute(\DTO $input): dto\LoginOutputDTO {
        if(!($input instanceof dto\LoginInputDTO)) {
            throw new \IncorrectDTOException();
        }

        $output = new dto\LoginOutputDTO();

        $user = orm\User::dao()->login(
            $input->login,
            $input->loginWithEmail,
            $input->password
        );

        if($user instanceof \struktal\Auth\LoginError) {
            switch($user) {
                case \struktal\Auth\LoginError::USER_NOT_FOUND:
                    Logger->tag("Login")->info("User \"{$input->login}\" failed to log in: User not found");
                    throw new exceptions\UserNotFoundException();
                case \struktal\Auth\LoginError::INVALID_PASSWORD:
                    Logger->tag("Login")->info("User \"{$input->login}\" failed to log in: Password incorrect");
                    throw new exceptions\InvalidPasswordException();
                case \struktal\Auth\LoginError::EMAIL_NOT_VERIFIED:
                    Logger->tag("Login")->info("User \"{$input->login}\" failed to log in: Email not verified");
                    throw new exceptions\UserNotVerifiedException();
            }
        }

        // Reset possibly existing one-time password
        $user->setOneTimePassword(null);
        $user->setOneTimePasswordExpiration(null);
        orm\User::dao()->save($user);

        Logger->tag("Login")->info("User \"{$input->login}\" has logged in (User ID {$user->getId()})");
        Auth->login($user);

        return $output;
    }
}
