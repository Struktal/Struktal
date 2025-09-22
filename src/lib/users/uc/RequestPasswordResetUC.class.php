<?php

namespace struktal\users\uc;

use \struktal\users\dto;
use \struktal\users\orm;
use \struktal\users\exceptions;

class RequestPasswordResetUC implements \UC {
    public function execute(\DTO $input): dto\RequestPasswordResetOutputDTO {
        if(!($input instanceof dto\RequestPasswordResetInputDTO)) {
            throw new \IncorrectDTOException();
        }

        $output = new dto\RequestPasswordResetOutputDTO();

        $user = orm\User::dao()->getObject([
            "email" => $input->email,
            "emailVerified" => true
        ]);

        if(!$user instanceof orm\User) {
            Logger->tag("Recovery")->info("Failed to request password recovery for email \"{$input->email}\"");
            throw new exceptions\UserNotFoundException();
        }

        // Send password recovery mail
        $oneTimePassword = orm\User::dao()->generateOneTimePassword();
        $now = new \DateTimeImmutable();
        $oneTimePasswordExpiration = $now->modify("+15 minutes");

        $user->setOneTimePassword($oneTimePassword);
        $user->setOneTimePasswordExpiration($oneTimePasswordExpiration);
        orm\User::dao()->save($user);

        $otpIdEncoded = urlencode(base64_encode($user->getId()));
        $otpEncoded = urlencode($oneTimePassword);
        $verificationLink = Router->generate("auth-recovery-reset", [], true) . "?otpid=" . $otpIdEncoded . "&otp=" . $otpEncoded;
        $mail = new \struktal\MailWrapper\MailWrapper();
        $mail->Subject = t("Password recovery");
        $mail->Body = t("You have requested to recover your password for your \$\$appName\$\$ account.", [
                "appName" => Config->getAppName()
            ]) . "\r\n"
            . t("To set a new password, please open the following link:") . "\r\n"
            . $verificationLink . "\r\n"
            . t("This link is valid for 15 minutes.") . "\r\n"
            . "\r\n"
            . t("If you haven't requested a password recovery for your \$\$appName\$\$ account, you can ignore this email.", [
                "appName" => Config->getAppName()
            ]);
        try {
            $mail->addAddress($user->email);
            $mail->send();
        } catch(\PHPMailer\PHPMailer\Exception $e) {
            Logger->tag("Recovery")->error("Failed to send password recovery email to \"{$input->email}\": " . $e->getMessage());
            throw new exceptions\InvalidEmailException($e->getMessage());
        }

        Logger->tag("Recovery")->info("Requested password recovery for user with email \"{$input->email}\" (User ID \"{$user->getId()}\")");

        return $output;
    }
}
