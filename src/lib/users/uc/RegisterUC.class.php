<?php

namespace struktal\users\uc;

use \struktal\users\dto;
use \struktal\users\orm;
use \struktal\users\exceptions;

class RegisterUC implements \UC {
    public function execute(\DTO $input): dto\RegisterOutputDTO {
        if(!($input instanceof dto\RegisterInputDTO)) {
            throw new \IncorrectDTOException();
        }

        $output = new dto\RegisterOutputDTO();

        // Check whether username and email are valid
        if(!preg_match("/^(?!.*\.\.)(?!.*\.$)\w[\w.]{2,15}$/", $input->username)) {
            throw new exceptions\InvalidUsernameException();
        }
        if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            throw new exceptions\InvalidEmailException();
        }

        // Check for existing users with the specified username or email
        $username = strtolower($_POST["username"]);
        $email = strtolower($_POST["email"]);
        $existingUsername = orm\User::dao()->getObjects([ "username" => $username ]);
        $existingEmail = orm\User::dao()->getObjects([ "email" => $email ]);

        if(!empty($existingUsername)) {
            throw new exceptions\UsernameAlreadyRegisteredException();
        }
        if(!empty($existingUsername) || !empty($existingEmail)) {
            throw new exceptions\EmailAlreadyRegisteredException();
        }

        // Register user
        $oneTimePassword = orm\User::dao()->generateOneTimePassword();
        $user = orm\User::dao()->register($username, $_POST["password"], $email, $input->permissionLevel, $oneTimePassword);

        Logger->tag("Register")->info("New user has been registered (\"{$username}\", \"{$email}\")");

        $output->user = $user;
        $output->otp = $oneTimePassword;
        return $output;
    }
}
