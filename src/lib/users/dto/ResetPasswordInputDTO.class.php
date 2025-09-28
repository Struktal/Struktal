<?php

namespace app\users\dto;

use \app\users\orm;

class ResetPasswordInputDTO implements \DTO {
    public orm\User $user;
    public string $password;
}
