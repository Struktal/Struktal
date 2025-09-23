<?php

namespace struktal\users\uc;

use \struktal\users\dto;

class StartPasswordResetSessionUC implements \UC {
    public function execute(\DTO $input): dto\StartPasswordResetSessionOutputDTO {
        if(!($input instanceof dto\StartPasswordResetSessionInputDTO)) {
            throw new \IncorrectDTOException();
        }

        $output = new dto\StartPasswordResetSessionOutputDTO();

        // Write user details to session
        $_SESSION["authRecoveryOtpId"] = $input->user->getId();
        $_SESSION["authRecoveryOtp"] = $input->otp;

        Logger->tag("Recovery")->info("Starting password recovery for user with email \"{$input->user->getEmail()}\" (User ID \"{$input->user->getId()}\")");

        return $output;
    }
}
