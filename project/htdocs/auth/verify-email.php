<?php

// Check whether a one-time password has been specified
if(empty($_GET["rstid"]) || empty($_GET["otp"])) {
    new InfoMessage("An error has occurred. Please try again later.", InfoMessageType::ERROR);
    Comm::redirect(Router::generate("auth-login"));
}

$rstId = base64_decode(urldecode($_GET["rstid"]));
$otp = urldecode($_GET["otp"]);

// Find the user from the one-time password
$user = User::dao()->getObject([
    "id" => $rstId,
    "emailVerified" => false,
    [
        "field" => "oneTimePassword",
        "filterType" => DAOFilterType::NOT_EQUALS,
        "filterValue" => null
    ],
    "oneTimePasswordExpiration" => null
]);
if(!$user instanceof User) {
    Logger::getLogger("Email-Verification")->info("Attempted to verify an email, but couldn't find user with rstid \"{$rstId}\"");
    new InfoMessage("The URL has already been invalidated. Please log in or request a new password recovery email.", InfoMessageType::ERROR);
    Comm::redirect(Router::generate("auth-login"));
}
if(!password_verify($otp, $user->getOneTimePassword())) {
    Logger::getLogger("Email-Verification")->info("Attempted to verify an email, but one-time password does not match");
    new InfoMessage("The URL has already been invalidated. Please log in or request a new password recovery email.", InfoMessageType::ERROR);
    Comm::redirect(Router::generate("auth-login"));
}

// Update the user object in the database
$user->setEmailVerified(true);
$user->setOneTimePassword(null);
$user->setOneTimePasswordExpiration(null);
$user->setUpdated(new DateTime());
User::dao()->save($user);

Logger::getLogger("Email-Verification")->info("The email address \"{$user->getEmail()}\" (User ID \"{$user->getId()}\") has been verified");

Comm::redirect(Router::generate("auth-verify-email-complete"));
