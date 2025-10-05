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

    public static function register(string $username, string $password, string $email, PermissionLevel $permissionLevel, bool $emailVerificationRequired = true): User {
        $oneTimePassword = "";
        if($emailVerificationRequired) {
            $oneTimePassword = User::dao()->generateOneTimePassword();
        }
        $user = User::dao()->register($username, $password, $email, $permissionLevel, $oneTimePassword);

        Logger->tag("Register")->info("New user has been registered (\"{$username}\", \"{$email}\")");

        if(!$emailVerificationRequired) {
            UserVerificationService::verify($user);
            return $user;
        }

        $verificationLink = UserVerificationService::generateVerificationLink($user->getId(), $oneTimePassword);

        // Send verification mail
        $mail = new \struktal\MailWrapper\MailWrapper();
        $mail->Subject = t("Verify your email address");
        $mail->Body = t("A new \$\$appName\$\$ account has been registered with this email address.", [
                "appName" => Config->getAppName()
            ]) . "\r\n"
            . t("To verify your email address and to complete the registration process, please open the following link:") . "\r\n"
            . $verificationLink . "\r\n"
            . "\r\n"
            . t("If you haven't registered an account at \$\$appName\$\$, you can ignore this email.", [
                "appName" => Config->getAppName()
            ]);
        $mail->addAddress($email);
        $mail->send();

        return $user;
    }
}
