<?php

class User extends \struktal\ORM\GenericUser {
    #[\struktal\ORM\InheritedType(PermissionLevel::class)]
    public ?\struktal\Auth\PermissionLevel $permissionLevel = null;
}
