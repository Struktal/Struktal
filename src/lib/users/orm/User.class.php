<?php

namespace struktal\users\orm;

class User extends \struktal\ORM\GenericUser {
    #[\struktal\ORM\InheritedType(\struktal\users\enums\PermissionLevel::class)]
    public ?\struktal\Auth\PermissionLevel $permissionLevel = null;
}
