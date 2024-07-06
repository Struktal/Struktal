<?php

// Check whether a one-time password has been specified
if(empty($_SESSION["otpid"]) || empty($_SESSION["otp"])) {
    new InfoMessage("An error has occurred. Please try again later.", InfoMessageType::ERROR);
    Comm::redirect(Router::generate("auth-login"));
}

$otpId = $_SESSION["otpid"];
$otp = $_SESSION["otp"];

$otpIdEncoded = urlencode(base64_encode($otpId));
$otpEncoded = urlencode($otp);
$resetLink = Router::generate("auth-recovery-reset") . "?otpid=" . $otpIdEncoded . "&otp=" . $otpEncoded;

// Find the user from the one-time password
$user = User::dao()->getObject([
    "id" => $otpId,
    "emailVerified" => false,
    [
        "field" => "oneTimePassword",
        "filterType" => DAOFilterType::NOT_EQUALS,
        "filterValue" => null
    ],
    [
        "field" => "oneTimePasswordExpiration",
        "filterType" => DAOFilterType::LESS_THAN_EQUALS,
        "filterValue" => DateFormatter::technicalDate()
    ]
]);
if(!$user instanceof User) {
    Logger::getLogger("Recovery")->info("Attempted to recover password, but couldn't find user with otpid \"{$otpId}\"");
    new InfoMessage("The URL has already been invalidated. Please log in or request a new password recovery email.", InfoMessageType::ERROR);
    Comm::redirect(Router::generate("auth-login"));
}
if(!password_verify($otp, $user->getOneTimePassword())) {
    Logger::getLogger("Recovery")->info("Attempted to recover password, but one-time password does not match");
    new InfoMessage("The URL has already been invalidated. Please log in or request a new password recovery email.", InfoMessageType::ERROR);
    Comm::redirect(Router::generate("auth-login"));
}

// Check whether form fields are given
if(empty($_POST["password"]) || empty($_POST["password-repeat"])) {
    new InfoMessage("Please fill out all the required fields.", InfoMessageType::ERROR);
    Comm::redirect($resetLink);
}

// Check passwords
if($_POST["password"] !== $_POST["password-repeat"]) {
    new InfoMessage("The specified passwords do not match. Please check for spelling errors and try again.", InfoMessageType::ERROR);
    Comm::redirect($resetLink);
}

// Change password
$user->setPassword($_POST["password"]);
$user->setOneTimePassword(null);
$user->setOneTimePasswordExpiration(null);
User::dao()->save($user);

Logger::getLogger("Recovery")->info("Changed password for user with email \"{$user->getEmail()}\" (User ID \"{$user->getId()}\")");

Comm::redirect(Router::generate("auth-recovery-reset-complete"));
