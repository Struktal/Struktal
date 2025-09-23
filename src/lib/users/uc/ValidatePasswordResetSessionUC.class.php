<?php

namespace struktal\users\uc;

use \struktal\users\dto;

class ValidatePasswordResetSessionUC implements \UC {
    public function execute(\DTO $input): dto\ValidatePasswordResetSessionOutputDTO {
        if(!($input instanceof dto\ValidatePasswordResetSessionInputDTO)) {
            throw new \IncorrectDTOException();
        }

        $output = new dto\ValidatePasswordResetSessionOutputDTO();

        // Check whether a one-time password has been specified
        $sessionValidation = Validation->create()
            ->withErrorMessage(t("An error has occurred. Please try again later."))
            ->array()
            ->required()
            ->children([
                "authRecoveryOtpId" => Validation->create()
                    ->int()
                    ->build(),
                "authRecoveryOtp" => Validation->create()
                    ->string()
                    ->minLength(1)
                    ->build()
            ])
            ->build();
        try {
            $session = $sessionValidation->getValidatedValue($_SESSION);
        } catch(\struktal\validation\ValidationException $e) {
            InfoMessage->error($e->getMessage());
            Router->redirect(Router->generate("auth-login"));
        }

        $otpId = $session["authRecoveryOtpId"];
        $otp = $session["authRecoveryOtp"];

        $output->otpId = $otpId;
        $output->otp = $otp;

        return $output;
    }
}
