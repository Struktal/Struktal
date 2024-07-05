<?php

echo Blade->run("auth.message", [
    "messages" => [
        "Your email address has been verified. You can now log into your account."
    ],
    "showLogin" => true
]);
