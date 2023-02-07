<?php

class User extends GenericObject {
    public string $username;
    public string $password;
    public string $email;
    public string $firstName;
    public string $lastName;
    public int $permissionLevel;
    public ?string $oneTimePassword;
    public ?DateTime $oneTimePasswordExpiration;
    
    /**
     * @return string
     */
    public function getUsername(): string {
        return $this->username;
    }
    
    /**
     * @param string $username
     */
    public function setUsername(string $username): void {
        $this->username = $username;
    }
    
    /**
     * @return string
     */
    public function getPassword(): string {
        return $this->password;
    }
    
    /**
     * @param string $password
     */
    public function setPassword(string $password): void {
        $this->password = $password;
    }
    
    /**
     * @return string
     */
    public function getEmail(): string {
        return $this->email;
    }
    
    /**
     * @param string $email
     */
    public function setEmail(string $email): void {
        $this->email = $email;
    }
    
    /**
     * @return string
     */
    public function getFirstName(): string {
        return $this->firstName;
    }
    
    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void {
        $this->firstName = $firstName;
    }
    
    /**
     * @return string
     */
    public function getLastName(): string {
        return $this->lastName;
    }
    
    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName): void {
        $this->lastName = $lastName;
    }
    
    /**
     * @return string
     */
    public function getFullName(): string {
        return $this->firstName . " " . $this->lastName;
    }
    
    /**
     * @return int
     */
    public function getPermissionLevel(): int {
        return $this->permissionLevel;
    }
    
    /**
     * @param int $permissionLevel
     */
    public function setPermissionLevel(int $permissionLevel): void {
        $this->permissionLevel = $permissionLevel;
    }
    
    /**
     * @return string|null
     */
    public function getOneTimePassword(): ?string {
        return $this->oneTimePassword;
    }
    
    /**
     * @param string $oneTimePassword
     */
    public function setOneTimePassword(string $oneTimePassword): void {
        $this->oneTimePassword = $oneTimePassword;
    }
    
    /**
     * @return DateTime|null
     */
    public function getOneTimePasswordExpiration(): ?DateTime {
        return $this->oneTimePasswordExpiration;
    }
    
    /**
     * @param DateTime $oneTimePasswordExpiration
     */
    public function setOneTimePasswordExpiration(DateTime $oneTimePasswordExpiration): void {
        $this->oneTimePasswordExpiration = $oneTimePasswordExpiration;
    }
}