<?php

echo Blade->run("auth.message", [
    "messages" => [
        "Your password has been changed.",
        "You can now log in to your account."
    ],
    "showLogin" => true
]);
