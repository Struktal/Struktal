<?php

namespace app\users;

class UserService {
    public static function login(string $username, bool $loginWithEmail, string $password): User {
        $user = User::dao()->login($username, $loginWithEmail, $password);

        if($user instanceof \struktal\Auth\LoginError) {
            if($user === \struktal\Auth\LoginError::USER_NOT_FOUND) {
                Logger->tag("Login")->info("User \"{$username}\" failed to log in: User not found");
                throw new UserNotFoundException();
            } else if($user === \struktal\Auth\LoginError::INVALID_PASSWORD) {
                Logger->tag("Login")->info("User \"{$username}\" failed to log in: Password incorrect");
                throw new InvalidPasswordException();
            } else if($user === \struktal\Auth\LoginError::EMAIL_NOT_VERIFIED) {
                Logger->tag("Login")->info("User \"{$username}\" failed to log in: Email not verified");
                throw new EmailNotVerifiedException();
            }
        }

        // Reset possibly existing one-time password
        $user->setOneTimePassword(null);
        $user->setOneTimePasswordExpiration(null);
        User::dao()->save($user);

        return $user;
    }

    public static function userExists(?string $username, ?string $email): bool {
        $filters = [];
        if($username !== null) {
            $filters["username"] = $username;
        }
        if($email !== null) {
            $filters["email"] = $email;
        }

        $existingUsers = User::dao()->getObjects($filters);
        return count($existingUsers) > 0;
    }
}
