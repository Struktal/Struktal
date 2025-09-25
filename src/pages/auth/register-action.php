<?php

// Check whether the user is already logged in
if(Auth->isLoggedIn()) {
    Router->redirect(Router->generate("index"));
}

function keepPostField(string $postField): void {
    if(isset($_POST[$postField])) {
        $_SESSION["register-" . $postField] = $_POST[$postField];
    }
}

// Check whether form fields are given
if(empty($_POST["username"]) || empty($_POST["email"]) || empty($_POST["password"]) || empty($_POST["password-repeat"])) {
    keepPostField("username");
    keepPostField("email");

    InfoMessage->error(t("Please fill out all the required fields."));
    Router->redirect(Router->generate("auth-register"));
}

$passwordEditCheckInput = new \struktal\users\dto\PasswordEditCheckInputDTO();
$passwordEditCheckInput->password = $_POST["password"];
$passwordEditCheckInput->passwordRepeat = $_POST["password-repeat"];

try {
    $passwordEditCheckOutput = \struktal\users\services\PasswordService::passwordEditCheck($passwordEditCheckInput);
} catch(\struktal\users\exceptions\PasswordMismatchException $e) {
    keepPostField("username");
    keepPostField("email");
    InfoMessage->error(t("The specified passwords do not match. Please check for spelling errors and try again."));
    Router->redirect(Router->generate("auth-register"));
} catch(\struktal\users\exceptions\WeakPasswordException $e) {
    keepPostField("username");
    keepPostField("email");
    InfoMessage->error(t("The specified password doesn't fulfill the password requirements. Please choose a safer password."));
    Router->redirect(Router->generate("auth-register"));
}

$registerInput = new \struktal\users\dto\RegisterInputDTO();
$registerInput->username = $_POST["username"];
$registerInput->email = $_POST["email"];
$registerInput->password = $passwordEditCheckOutput->password;
$registerInput->permissionLevel = \struktal\users\enums\PermissionLevel::USER;

try {
    $registerOutput = \struktal\users\services\UserService::register($registerInput);
} catch(\struktal\users\exceptions\InvalidUsernameException $e) {
    keepPostField("username");
    keepPostField("email");
    InfoMessage->error(t("The specified username is invalid. Please follow the required username scheme."));
    Router->redirect(Router->generate("auth-register"));
} catch(\struktal\users\exceptions\InvalidEmailException $e) {
    keepPostField("username");
    keepPostField("email");
    InfoMessage->error(t("The specified email address is invalid. Please check for spelling errors and try again."));
    Router->redirect(Router->generate("auth-register"));
} catch(\struktal\users\exceptions\UsernameAlreadyRegisteredException $e) {
    keepPostField("email");
    InfoMessage->error(t("An account with this username already exists. Please choose another one."));
    Router->redirect(Router->generate("auth-register"));
} catch(\struktal\users\exceptions\EmailAlreadyRegisteredException $e) {
    keepPostField("username");
    InfoMessage->error(t("An account with this email already exists. If that is your account, please log in instead."));
    Router->redirect(Router->generate("auth-register"));
} catch(\Exception $e) {
    Logger->tag("Register")->error("An unexpected error occurred during registration of user \"{$registerInput->username}\": " . $e->getMessage());
    InfoMessage->error(t("An error has occurred. Please try again later."));
    Router->redirect(Router->generate("auth-register"));
}

$sendVerificationEmailInput = new \struktal\users\dto\SendVerificationEmailInputDTO();
$sendVerificationEmailInput->user = $registerOutput->user;
$sendVerificationEmailInput->otp = $registerOutput->otp;

try {
    \struktal\users\services\UserVerificationService::sendVerificationEmail($sendVerificationEmailInput);
} catch(\Exception $e) {
    Logger->tag("Register")->error("An unexpected error occurred during sending of verification email to user with ID \"{$registerOutput->user->getId()}\": " . $e->getMessage());
    InfoMessage->error(t("An error has occurred. Please try again later."));
    Router->redirect(Router->generate("auth-register"));
}

Router->redirect(Router->generate("auth-register-complete"));
