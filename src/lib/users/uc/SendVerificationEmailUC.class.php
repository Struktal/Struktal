<?php

namespace app\users\uc;

use \app\users\services;
use \app\users\dto;
use \app\users\exceptions;

class SendVerificationEmailUC implements \UC {
    public function execute(\DTO $input): dto\SendVerificationEmailOutputDTO {
        if(!($input instanceof dto\SendVerificationEmailInputDTO)) {
            throw new \IncorrectDTOException();
        }

        $output = new dto\SendVerificationEmailOutputDTO();

        $generateVerificationLinkInput = new dto\GenerateVerificationLinkInputDTO();
        $generateVerificationLinkInput->user = $input->user;
        $generateVerificationLinkInput->otp = $input->otp;
        $verificationLink = services\UserVerificationService::generateVerificationLink($generateVerificationLinkInput)->link;

        $mail = new \struktal\MailWrapper\MailWrapper();
        $mail->Subject = t("Verify your email address");
        $mail->Body = t("A new \$\$appName\$\$ account has been registered with this email address.", [
                "appName" => Config->getAppName()
            ]) . "\r\n"
            . t("To verify your email address and to complete the registration process, please open the following link:") . "\r\n"
            . $verificationLink . "\r\n"
            . "\r\n"
            . t("If you haven't registered an account at \$\$appName\$\$, you can ignore this email.", [
                "appName" => Config->getAppName()
            ]);
        try {
            $mail->addAddress($input->user->getEmail());
            $mail->send();
        } catch(\PHPMailer\PHPMailer\Exception $e) {
            Logger->tag("UserVerification")->error("Failed to send verification email to user ID {$input->user->getId()}: " . $e->getMessage());
            throw new exceptions\InvalidEmailException();
        }

        Logger->tag("UserVerification")->info("Sent verification email to user ID {$input->user->getId()}");

        return $output;
    }
}
