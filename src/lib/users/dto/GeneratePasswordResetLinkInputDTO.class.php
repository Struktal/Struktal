<?php

namespace app\users\dto;

use \app\users\orm;

class GeneratePasswordResetLinkInputDTO implements \DTO {
    public orm\User $user;
    public string $otp;
}
