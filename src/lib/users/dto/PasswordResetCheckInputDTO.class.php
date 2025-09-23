<?php

namespace struktal\users\dto;

class PasswordResetCheckInputDTO implements \DTO {
    public string $password;
    public string $passwordRepeat;
}
