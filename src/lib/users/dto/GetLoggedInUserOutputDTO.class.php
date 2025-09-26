<?php

namespace struktal\users\dto;

use \struktal\users\orm;

class GetLoggedInUserOutputDTO implements \DTO {
    public ?orm\User $user;
}
