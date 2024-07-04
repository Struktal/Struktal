<?php

// Check whether form fields are given
if(empty($_POST["email"])) {
    new InfoMessage("Please enter your accounts verified email address.", InfoMessageType::ERROR);
    Comm::redirect(Router::generate("auth-recovery-request"));
}

$email = strtolower($_POST["email"]);

$user = User::dao()->getObject(["email" => $email]);

if(!$user instanceof GenericUser) {
    Logger::getLogger("Recovery")->info("Failed to request password recovery for email \"{$_POST["email"]}\"");
    new InfoMessage("An account with this email could not be found. Please check for spelling errors and try again.", InfoMessageType::ERROR);
    Comm::redirect(Router::generate("auth-recovery-request"));
}

// TODO: Send password recovery mail

Logger::getLogger("Recovery")->info("Requested password recovery for user with email \"{$_POST["email"]}\" (User ID {$user->getId()})");
Comm::redirect(Router::generate("auth-recovery-request-complete"));
