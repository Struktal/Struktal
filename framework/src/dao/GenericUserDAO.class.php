<?php

class GenericUserDAO extends GenericObjectDAO {
    /**
     * Authentification of a Login
     * @param string $login Username or E-Mail
     * @param bool $loginWithEmail Login performed with E-Mail instead of Username
     * @param string $password Provided Password
     * @return GenericUser|null User or null if Login failed
     */
    public function login(string $login, bool $loginWithEmail, string $password): ?GenericUser {
        $user = null;
        if($loginWithEmail) {
            $login = strtolower($login);
            $user = $this->getObject(array(
                "email" => $login,
                "deleted" => false
            ));
        } else {
            $user = $this->getObject(array(
                "username" => $login,
                "deleted" => false
            ));
        }

        if($user instanceof GenericUser) {
            if(password_verify($password, $user->getPassword())) {
                return $user;
            }
        }

        return null;
    }
}