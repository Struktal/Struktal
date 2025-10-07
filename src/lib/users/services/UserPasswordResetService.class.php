<?php

namespace app\users;

class UserPasswordResetService {
    public static function generateRecoveryLink(int $otpId, string $otp): string {
        $otpIdEncoded = urlencode(base64_encode($otpId));
        $otpEncoded = urlencode(base64_encode($otp));

        return Router->generate("auth-recovery-reset", [], true) . "?otpid=" . $otpIdEncoded . "&otp=" . $otpEncoded;
    }
}
