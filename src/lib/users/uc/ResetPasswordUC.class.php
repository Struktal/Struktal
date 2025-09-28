<?php

namespace app\users\uc;

use \app\users\dto;
use \app\users\orm;

class ResetPasswordUC implements \UC {
    public function execute(\DTO $input): dto\ResetPasswordOutputDTO {
        if(!($input instanceof dto\ResetPasswordInputDTO)) {
            throw new \IncorrectDTOException();
        }

        $output = new dto\ResetPasswordOutputDTO();

        $user = $input->user;

        $user->setPassword($input->password);
        $user->setOneTimePassword(null);
        $user->setOneTimePasswordExpiration(null);
        $user->setUpdated(new \DateTimeImmutable());
        orm\User::dao()->save($user);

        Logger->tag("PasswordReset")->info("Changed password for user with email \"{$user->getEmail()}\" (User ID \"{$user->getId()}\")");

        return $output;
    }
}
