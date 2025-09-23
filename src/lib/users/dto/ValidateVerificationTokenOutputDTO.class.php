<?php

namespace struktal\users\dto;

use \struktal\users\orm;

class ValidateVerificationTokenOutputDTO implements \DTO {
    public orm\User $user;
}
