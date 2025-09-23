<?php

namespace struktal\users\dto;

use \struktal\users\orm;

class StartPasswordResetSessionInputDTO implements \DTO {
    public orm\User $user;
    public string $otp;
}
