<?php

class Login {
    /**
     * Enforce the User to be logged in
     * @param mixed $userId User ID
     * @param int $requiredPermissionLevel Minimum required Permission Level
     * @param string $redirect Redirect URL if the User is not logged in
     * @return GenericUser|null User Object or null if the User is not logged in
     */
    public static function enforce(mixed $userId, int $requiredPermissionLevel, string $redirect): ?GenericUser {
        if(empty($userId) || !(is_int($userId))) {
            Comm::redirect($redirect);
            return null;
        }

        $user = User::dao()->getObject(array("id" => $userId, "emailVerified" => true, "deleted" => false));

        if($user instanceof User) {
            return $user;
        }

        Comm::redirect($redirect);
        return null;
    }
}
