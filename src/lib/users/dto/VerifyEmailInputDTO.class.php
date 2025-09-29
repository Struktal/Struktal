<?php

namespace app\users\dto;

use \app\users\orm;

class VerifyEmailInputDTO implements \DTO {
    public orm\User $user;
}
