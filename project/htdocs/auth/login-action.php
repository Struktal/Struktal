<?php

// Check whether form fields are given
if(empty($_POST["username"]) || empty($_POST["password"])) {
    new InfoMessage("Please sign in with your accounts credentials.", InfoMessageType::ERROR);
    Comm::redirect(Router::generate("auth-login"));
}

$user = User::dao()->login($_POST["username"], false, $_POST["password"]);

if(!$user instanceof GenericUser) {
    if($user === 2) {
        $message = "Before logging in, please verify your accounts email address.";
    } else {
        $message = "An account with these credentials could not be found. Please check for spelling errors and try again.";

        // TODO: Re-send verification mail
    }

    Logger::getLogger("Login")->info("User \"{$_POST["username"]}\" failed to log in: " . ($user === 0 ? "User not found" : ($user === 1 ? "Password incorrect" : "Email not verified")));
    new InfoMessage($message, InfoMessageType::ERROR);
    Comm::redirect(Router::generate("auth-login"));
}

Logger::getLogger("Login")->info("User \"{$_POST["username"]}\" has logged in (User ID {$user->getId()})");
Auth::login($user);
Comm::redirect(Router::generate("index"));
