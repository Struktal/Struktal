<?php

namespace struktal\users\uc;

use \struktal\users\dto;
use \struktal\users\validations;
use \struktal\users\exceptions;

class ValidatePasswordResetSessionUC implements \UC {
    public function execute(\DTO $input): dto\ValidatePasswordResetSessionOutputDTO {
        if(!($input instanceof dto\ValidatePasswordResetSessionInputDTO)) {
            throw new \IncorrectDTOException();
        }

        $output = new dto\ValidatePasswordResetSessionOutputDTO();

        // Check whether a one-time password has been specified
        $sessionValidation = Validation->create()
            ->array()
            ->required()
            ->children([
                "authRecoveryOtpId" => Validation->create()
                    ->int()
                    ->build(),
                "authRecoveryOtp" => validations\Validations::otp()
            ])
            ->build();
        try {
            $session = $sessionValidation->getValidatedValue($_SESSION);
        } catch(\struktal\validation\ValidationException $e) {
            Logger->tag("PasswordReset")->info("Attempted to reset password, but no valid session OTP found");
            throw new exceptions\InvalidTokenException();
        }

        $otpId = $session["authRecoveryOtpId"];
        $otp = $session["authRecoveryOtp"];

        $output->otpId = $otpId;
        $output->otp = $otp;

        return $output;
    }
}
