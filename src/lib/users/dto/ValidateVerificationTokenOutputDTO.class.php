<?php

namespace app\users\dto;

use \app\users\orm;

class ValidateVerificationTokenOutputDTO implements \DTO {
    public orm\User $user;
}
