<?php

namespace struktal\users\dto;

use \struktal\users\orm;

class ResetPasswordInputDTO implements \DTO {
    public orm\User $user;
    public string $password;
}
