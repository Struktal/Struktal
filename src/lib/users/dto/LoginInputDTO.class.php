<?php

namespace struktal\users\dto;

class LoginInputDTO implements \DTO {

    public string $login;
    public bool $loginWithEmail;
    public string $password;
}
