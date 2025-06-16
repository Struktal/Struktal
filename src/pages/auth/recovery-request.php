<?php

// Check whether the user is already logged in
if(Auth::isLoggedIn()) {
    Comm::redirect(Router->enerate("index"));
}

echo Blade->run("auth.recoveryrequest");
