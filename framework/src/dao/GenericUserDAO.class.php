<?php

class GenericUserDAO extends GenericObjectDAO {
    /**
     * Authentification of a Login
     * @param string $login Username or E-Mail
     * @param bool $loginWithEmail Login performed with E-Mail instead of Username
     * @param string $password Provided Password
     * @return GenericUser|int User or Error Code if Login failed
     *                         0: Login not found
     *                         1: Password incorrect
     */
    public function login(string $login, bool $loginWithEmail, string $password): GenericUser|int {
        if($loginWithEmail) {
            $login = strtolower($login);
            $user = $this->getObject(array(
                "email" => $login,
                "emailVerified" => true,
                "deleted" => false
            ));
        } else {
            $user = $this->getObject(array(
                "username" => $login,
                "emailVerified" => true,
                "deleted" => false
            ));
        }

        if($user instanceof GenericUser) {
            if(password_verify($password, $user->getPassword())) {
                return $user;
            }
        } else {
            return 0;
        }

        return 1;
    }

    /**
     * Register a new User
     * @param string $username Username
     * @param string $password Password
     * @param string $email E-Mail
     * @param int $permissionLevel Permission Level
     * @param string $oneTimePassword One-Time-Password for E-Mail Verification
     * @return void
     */
    public function register(string $username, string $password, string $email, int $permissionLevel, string $oneTimePassword): void {
        $user = new User();
        $user->setUsername($username);
        $user->setPassword($password);
        $user->setEmail($email);
        $user->setEmailVerified(false);
        $user->setPermissionLevel($permissionLevel);
        $user->setOneTimePassword($oneTimePassword);
        $user->setOneTimePasswordExpiration(null);
        $this->save($user);
    }

    /**
     * Generate a unique One-Time-Password
     * @return string One-Time-Password
     */
    public function generateOneTimePassword(): string {
        $chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $oneTimePassword = "";
        for($i = 0; $i < 127; $i++) {
            $oneTimePassword .= $chars[rand(0, strlen($chars) - 1)];
        }

        // Check whether the generated One-Time-Password already exists
        if(sizeof($this->getObjects(array("oneTimePassword" => $oneTimePassword, "deleted" => false))) + sizeof($this->getObjects(array("oneTimePassword" => $oneTimePassword, "deleted" => true))) > 0) {
            $oneTimePassword = $this->generateOneTimePassword();
        }

        return $oneTimePassword;
    }
}