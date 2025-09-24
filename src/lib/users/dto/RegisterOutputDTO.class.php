<?php

namespace struktal\users\dto;

use \struktal\users\orm;

class RegisterOutputDTO implements \DTO {
    public orm\User $user;
    public string $otp;
}
