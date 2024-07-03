<?php

echo Blade->run("auth.message", [
    "messages" => [
        "Your account has been registered.",
        "Please open the verification link that has been sent to you per email. You can log into your account once your email address has been verified."
    ],
    "showLogin" => false
]);
