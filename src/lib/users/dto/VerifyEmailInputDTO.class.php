<?php

namespace struktal\users\dto;

use \struktal\users\orm;

class VerifyEmailInputDTO implements \DTO {
    public orm\User $user;
}
