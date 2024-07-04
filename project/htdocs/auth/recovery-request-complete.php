<?php

echo Blade->run("auth.message", [
    "messages" => [
        "You have requested a password recovery.",
        "Shortly, you will receive an email with a link. Please open that link to set a new password."
    ],
    "showLogin" => false
]);
