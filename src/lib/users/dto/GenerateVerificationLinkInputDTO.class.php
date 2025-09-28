<?php

namespace app\users\dto;

use \app\users\orm;

class GenerateVerificationLinkInputDTO implements \DTO {
    public orm\User $user;
    public string $otp;
}
