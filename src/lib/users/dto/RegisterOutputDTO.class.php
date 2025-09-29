<?php

namespace app\users\dto;

use \app\users\orm;

class RegisterOutputDTO implements \DTO {
    public orm\User $user;
    public string $otp;
}
