<?php

class GenericUser extends GenericObject {
    public string $username = "";
    public string $password = "";
    public string $email = "";
    public bool $emailVerified = false;
    public int $permissionLevel = 0;
    public ?string $oneTimePassword = null;
    public ?DateTime $oneTimePasswordExpiration = null;

    /**
     * Get the User's Username
     * @return string
     */
    public function getUsername(): string {
        return $this->username;
    }

    /**
     * Set the User's Username
     * @param string $username
     */
    public function setUsername(string $username): void {
        $this->username = $username;
    }

    /**
     * Get the User's Password Hash
     * @return string
     */
    public function getPassword(): string {
        return $this->password;
    }

    /**
     * Set the User's Password
     * The passed Password will be hashed with the default PHP Hashing Algorithm
     * @param string $password
     */
    public function setPassword(string $password): void {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * Get the User's E-Mail
     * @return string
     */
    public function getEmail(): string {
        return $this->email;
    }

    /**
     * Set the User's E-Mail
     * The E-Mail will be converted to lowercase Letters
     * @param string $email
     */
    public function setEmail(string $email): void {
        $this->email = strtolower($email);
    }

    /**
     * Get the User's E-Mail Verification Status
     * @return bool
     */
    public function getEmailVerified(): bool {
        return $this->emailVerified;
    }

    /**
     * Set the User's E-Mail Verification Status
     * @param bool $emailVerified
     */
    public function setEmailVerified(bool $emailVerified): void {
        $this->emailVerified = $emailVerified;
    }

    /**
     * Get the User's Permission Level
     * @return int
     */
    public function getPermissionLevel(): int {
        return $this->permissionLevel;
    }

    /**
     * Set the User's Permission Level
     * @param int $permissionLevel
     */
    public function setPermissionLevel(int $permissionLevel): void {
        $this->permissionLevel = $permissionLevel;
    }

    /**
     * Get the User's One-Time-Password
     * @return string|null
     */
    public function getOneTimePassword(): ?string {
        return $this->oneTimePassword;
    }

    /**
     * Set the User's One-Time-Password
     * The One-Time-Password will be hashed with the default PHP Hashing Algorithm
     * @param string|null $oneTimePassword
     */
    public function setOneTimePassword(?string $oneTimePassword): void {
        if($oneTimePassword !== null) {
            $this->oneTimePassword = password_hash($oneTimePassword, PASSWORD_DEFAULT);
        } else {
            $this->oneTimePassword = null;
        }
    }

    /**
     * Get the User's One-Time-Password Expiration Date
     * @return DateTime|null
     */
    public function getOneTimePasswordExpiration(): ?DateTime {
        return $this->oneTimePasswordExpiration;
    }

    /**
     * Set the User's One-Time-Password Expiration Date
     * @param DateTime|null $oneTimePasswordExpiration
     */
    public function setOneTimePasswordExpiration(?DateTime $oneTimePasswordExpiration): void {
        $this->oneTimePasswordExpiration = $oneTimePasswordExpiration;
    }
}