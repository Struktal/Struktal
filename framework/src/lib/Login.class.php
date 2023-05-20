<?php

class Login {
    /**
     * Enforce the User to be logged in
     * @param mixed $userId User ID
     * @param int $requiredPermissionLevel Minimum required Permission Level
     * @param string $redirect Redirect URL if the User is not logged in
     * @return GenericUser|null User Object or null if the User is not logged in
     */
    public static function requireLogin(mixed $userId, int $requiredPermissionLevel, string $redirect): ?GenericUser {
        if(empty($userId) || !(is_int($userId))) {
            Comm::redirect($redirect);
            return null;
        }

        $user = User::dao()->getObject(array("id" => $userId, "emailVerified" => true));

        if($user instanceof User) {
            if($user->getPermissionLevel() >= $requiredPermissionLevel) {
                return $user;
            }
        }

        Comm::redirect($redirect);
        return null;
    }

    /**
     * Check whether the Page was called by a logged in User
     * @param mixed $userId User ID
     * @return GenericUser|null User Object or null if no User is logged in
     */
    public static function optionalLogin(mixed $userId): ?GenericUser {
        if(empty($userId) || !(is_int($userId))) {
            return null;
        }

        $user = User::dao()->getObject(array("id" => $userId, "emailVerified" => true));

        if($user instanceof User) {
            return $user;
        }

        return null;
    }
}
