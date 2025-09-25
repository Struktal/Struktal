<?php

namespace struktal\users\uc;

use \struktal\users\dto;
use \struktal\users\orm;
use \struktal\users\exceptions;

class ValidateVerificationTokenUC implements \UC {
    public function execute(\DTO $input): dto\ValidateVerificationTokenOutputDTO {
        if(!($input instanceof dto\ValidateVerificationTokenInputDTO)) {
            throw new \IncorrectDTOException();
        }

        $output = new dto\ValidateVerificationTokenOutputDTO();

        $otpId = base64_decode(urldecode($input->otpId));
        $otp = urldecode($input->otp);

        // Find the user from the one-time password
        $user = orm\User::dao()->getObject([
            "id" => $otpId,
            "emailVerified" => false,
            new \struktal\ORM\DAOFilter(
                \struktal\ORM\DAOFilterOperator::NOT_EQUALS,
                "oneTimePassword",
                null
            ),
            "oneTimePasswordExpiration" => null
        ]);
        if(!$user instanceof orm\User) {
            Logger->tag("Email-Verification")->info("Attempted to verify an email, but couldn't find user with otpid \"{$otpId}\"");
            throw new exceptions\UserNotFoundException();
        }
        if(!password_verify($otp, $user->getOneTimePassword())) {
            Logger->tag("Email-Verification")->info("Attempted to verify an email, but one-time password does not match");
            throw new exceptions\InvalidTokenException();
        }

        $output->user = $user;
        return $output;
    }
}
