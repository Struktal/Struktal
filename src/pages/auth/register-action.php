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

// Clean up username and email
try {
    $username = \app\users\Validations::sanitizeUsername($_POST["username"]);
    $email = \app\users\Validations::sanitizeEmail($_POST["email"]);
} catch(\app\users\InvalidUsernameException $e) {
    keepPostField("username");
    keepPostField("email");
    InfoMessage->error(t("The specified username is invalid. Please follow the required username scheme."));
    Router->redirect(Router->generate("auth-register"));
} catch(\app\users\InvalidEmailException $e) {
    keepPostField("username");
    keepPostField("email");
    InfoMessage->error(t("The specified email address is invalid. Please check for spelling errors and try again."));
    Router->redirect(Router->generate("auth-register"));
}

// Check for existing users with the specified username or email
if(\app\users\UserService::userExists($username, null)) {
    if(empty($existingEmail)) {
        keepPostField("email");
    }
    InfoMessage->error(t("An account with this username already exists. Please choose another one."));
    Router->redirect(Router->generate("auth-register"));
}
if(\app\users\UserService::userExists(null, $email)) {
    if(empty($existingUsername)) {
        keepPostField("username");
    }
    InfoMessage->error(t("An account with this email already exists. If that is your account, please log in instead."));
    Router->redirect(Router->generate("auth-register"));
}

// Check passwords
try {
    \app\users\Validations::checkTwoPasswords($_POST["password"], $_POST["password-repeat"]);
} catch(\app\users\PasswordMismatchException $e) {
    keepPostField("username");
    keepPostField("email");
    InfoMessage->error(t("The specified passwords do not match. Please check for spelling errors and try again."));
    Router->redirect(Router->generate("auth-register"));
} catch(\app\users\WeakPasswordException $e) {
    keepPostField("username");
    keepPostField("email");
    InfoMessage->error(t("The specified password doesn't fulfill the password requirements. Please choose a safer password."));
    Router->redirect(Router->generate("auth-register"));
}

// Register user
$oneTimePassword = \app\users\User::dao()->generateOneTimePassword();
$user = \app\users\User::dao()->register($username, $_POST["password"], $email, \app\users\PermissionLevel::USER, $oneTimePassword);

// Send verification email
$otpIdEncoded = urlencode(base64_encode($user->getId()));
$otpEncoded = urlencode($oneTimePassword);
$verificationLink = Router->generate("auth-verify-email", [], true) . "?otpid=" . $otpIdEncoded . "&otp=" . $otpEncoded;
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

Logger->tag("Register")->info("New user has been registered (\"{$username}\", \"{$email}\")");

Router->redirect(Router->generate("auth-register-complete"));
