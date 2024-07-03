<?php

// Check whether a one-time password has been specified
if(empty($_GET["otp"])) {
    new InfoMessage("An error has occurred. Please try again later.", InfoMessageType::ERROR);
    Comm::redirect(Router::generate("auth-login"));
}

// Find the user from the one-time password
$user = User::dao()->getObject([
    "oneTimePassword" => $_GET["otp"],
    "oneTimePasswordExpiration" => null
]);
if(!$user instanceof User) {
    Logger::getLogger("Email-Verification")->info("Attempted to verify an email with the invalid one-time password \"{$_GET["otp"]}\"");
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

Blade->run("auth.message", [
    "messages" => [
        "Your email address has been verified. You can now log into your account."
    ],
    "showLogin" => true
]);
