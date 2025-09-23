<?php

namespace struktal\users\dto;

class ValidateVerificationTokenInputDTO implements \DTO {
    public string $otpId;
    public string $otp;
}
