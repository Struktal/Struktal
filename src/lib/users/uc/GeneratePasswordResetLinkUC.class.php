<?php

namespace struktal\users\uc;

use \struktal\users\dto;

class GeneratePasswordResetLinkUC implements \UC {
    public function execute(\DTO $input): dto\GeneratePasswordResetLinkOutputDTO {
        if(!($input instanceof dto\GeneratePasswordResetLinkInputDTO)) {
            throw new \IncorrectDTOException();
        }

        $output = new dto\GeneratePasswordResetLinkOutputDTO();

        $otpId = $input->user->getId();
        $otpIdEncoded = urlencode(base64_encode($otpId));
        $otpEncoded = urlencode($input->otp);
        $verificationLink = Router->generate("auth-recovery-reset", [], true) . "?otpid=" . $otpIdEncoded . "&otp=" . $otpEncoded;

        $output->link = $verificationLink;
        return $output;
    }
}
