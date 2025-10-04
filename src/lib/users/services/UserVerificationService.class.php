<?php

namespace app\users;

class UserVerificationService {
    public static function generateVerificationLink(int $otpId, string $otp): string {
        $otpIdEncoded = urlencode(base64_encode($otpId));
        $otpEncoded = urlencode(base64_encode($otp));

        return Router->generate("auth-verify-email", [], true) . "?otpid=" . $otpIdEncoded . "&otp=" . $otpEncoded;;
    }
}
