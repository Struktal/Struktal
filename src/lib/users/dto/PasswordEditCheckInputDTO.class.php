<?php

namespace app\users\dto;

class PasswordEditCheckInputDTO implements \DTO {
    public string $password;
    public string $passwordRepeat;
}
