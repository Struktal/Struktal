<?php

namespace struktal\users\dto;

use struktal\users\enums\PermissionLevel;

class RegisterInputDTO implements \DTO {
    public string $username;
    public string $email;
    public string $password;
    public PermissionLevel $permissionLevel;
}
