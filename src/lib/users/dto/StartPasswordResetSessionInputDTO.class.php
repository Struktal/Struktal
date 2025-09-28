<?php

namespace app\users\dto;

use \app\users\orm;

class StartPasswordResetSessionInputDTO implements \DTO {
    public orm\User $user;
    public string $otp;
}
