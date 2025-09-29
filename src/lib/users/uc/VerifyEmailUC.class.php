<?php

namespace app\users\uc;

use \app\users\dto;
use \app\users\orm;

class VerifyEmailUC implements \UC {
    public function execute(\DTO $input): dto\VerifyEmailOutputDTO {
        if(!($input instanceof dto\VerifyEmailInputDTO)) {
            throw new \IncorrectDTOException();
        }

        $output = new dto\VerifyEmailOutputDTO();

        $user = $input->user;
        $user->setEmailVerified(true);
        $user->setOneTimePassword(null);
        $user->setOneTimePasswordExpiration(null);
        $user->setUpdated(new \DateTimeImmutable());
        orm\User::dao()->save($user);

        Logger->tag("Email-Verification")->info("The email address \"{$user->getEmail()}\" (User ID \"{$user->getId()}\") has been verified");

        return $output;
    }
}
