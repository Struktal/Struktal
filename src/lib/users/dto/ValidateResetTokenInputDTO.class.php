<?php

namespace app\users\dto;

class ValidateResetTokenInputDTO implements \DTO {
    public int|string $otpId;
    public string $otp;
    public bool $isUrlEncoded;
}
