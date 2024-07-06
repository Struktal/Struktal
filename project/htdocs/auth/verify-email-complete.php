<?php

// Check whether the user is already logged in
if(Auth::isLoggedIn()) {
    Comm::redirect(Router::generate("index"));
}

echo Blade->run("auth.message", [
    "messages" => [
        "Your email address has been verified. You can now log into your account."
    ],
    "showLogin" => true
]);
