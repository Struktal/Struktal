<?php

namespace struktal\users\uc;

use \struktal\users\dto;

class GenerateVerificationLinkUC implements \UC {
    public function execute(\DTO $input): dto\GenerateVerificationLinkOutputDTO {
        if(!($input instanceof dto\GenerateVerificationLinkInputDTO)) {
            throw new \IncorrectDTOException();
        }

        $output = new dto\GenerateVerificationLinkOutputDTO();

        $otpIdEncoded = urlencode(base64_encode($input->user->getId()));
        $otpEncoded = urlencode($input->otp);
        $verificationLink = Router->generate("auth-verify-email", [], true) . "?otpid=" . $otpIdEncoded . "&otp=" . $otpEncoded;

        $output->link = $verificationLink;

        return $output;
    }
}
