<?php

namespace app\users\dto;

use \app\users\enums\PermissionLevel;

class RegisterInputDTO implements \DTO {
    public string $username;
    public string $email;
    public string $password;
    public PermissionLevel $permissionLevel;
}
