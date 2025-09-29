<?php

namespace app\users\uc;

use \app\users\dto;

class GenerateVerificationLinkUC implements \UC {
    public function execute(\DTO $input): dto\GenerateVerificationLinkOutputDTO {
        if(!($input instanceof dto\GenerateVerificationLinkInputDTO)) {
            throw new \IncorrectDTOException();
        }

        $output = new dto\GenerateVerificationLinkOutputDTO();

        $otpId = $input->user->getId();
        $otpIdEncoded = urlencode(base64_encode($otpId));
        $otpEncoded = urlencode($input->otp);
        $verificationLink = Router->generate("auth-verify-email", [], true) . "?otpid=" . $otpIdEncoded . "&otp=" . $otpEncoded;

        $output->link = $verificationLink;
        return $output;
    }
}
