<?php

namespace struktal\users\dto;

class PasswordEditCheckInputDTO implements \DTO {
    public string $password;
    public string $passwordRepeat;
}
