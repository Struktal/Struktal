<?php

namespace app\users\dto;

use \app\users\orm;

class GetLoggedInUserOutputDTO implements \DTO {
    public ?orm\User $user;
}
