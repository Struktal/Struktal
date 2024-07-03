<?php

function keepPostField(string $postField): void {
    if(isset($_POST[$postField])) {
        $_SESSION["register-" . $postField] = $_POST[$postField];
    }
}

// Check whether form fields are given
if(empty(empty($_POST["username"]) || $_POST["email"]) || empty($_POST["password"]) || empty($_POST["password-repeat"])) {
    keepPostField("username");
    keepPostField("email");

    new InfoMessage("Please fill out all the required fields.", InfoMessageType::ERROR);
    Comm::redirect(Router::generate("auth-register"));
}

// Check for existing users with the specified username or email
$username = strtolower($_POST["username"]);
$email = strtolower($_POST["email"]);
$existingUsername = User::dao()->getObjects(["username" => $username]);
$existingEmail = User::dao()->getObjects(["email" => $email]);
if(!empty($existingUsername)) {
    if(empty($existingEmail)) {
        keepPostField("email");
    }
    new InfoMessage("An account with this username already exists. Please choose another one.", InfoMessageType::ERROR);
    Comm::redirect(Router::generate("auth-register"));
}
if(!empty($existingUsername) || !empty($existingEmail)) {
    if(empty($existingUsername)) {
        keepPostField("username");
    }
    new InfoMessage("An account with this email already exists. If that is your account, please log in instead.", InfoMessageType::ERROR);
    Comm::redirect(Router::generate("auth-register"));
}

// Check passwords
if($_POST["password"] !== $_POST["password-repeat"]) {
    keepPostField("username");
    keepPostField("email");
    new InfoMessage("The specified passwords do not match. Please check for spelling errors and try again.", InfoMessageType::ERROR);
    Comm::redirect(Router::generate("auth-register"));
}

// Register user
$oneTimePassword = User::dao()->generateOneTimePassword();
User::dao()->register($username, $_POST["password"], $email, 1, $oneTimePassword);

// TODO: Send verification email

Logger::getLogger("Register")->info("New user has been registered (\"{$username}\", \"{$email}\")");

Comm::redirect(Router::generate("auth-register-complete"));
