<?php

namespace app\users\orm;

class User extends \struktal\ORM\GenericUser {
    #[\struktal\ORM\InheritedType(\app\users\enums\PermissionLevel::class)]
    public ?\struktal\Auth\PermissionLevel $permissionLevel = null;
}
