<?php

namespace app\users\dto;

class ValidatePasswordResetSessionOutputDTO implements \DTO {
    public int $otpId;
    public string $otp;
}
