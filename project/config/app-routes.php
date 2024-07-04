<?php

Router::addRoute("GET", "/", "index.php", "index");
Router::addRoute("GET|POST", "/404", "404.php", "404");
Router::addRoute("GET|POST", "/400", "400.php", "400");

Router::addRoute("GET", "/design", "design.php", "design");

// Authentication
Router::addRoute("GET", "/auth/login", "auth/login.php", "auth-login");
Router::addRoute("POST", "/auth/login", "auth/login-action.php", "auth-login-action");
Router::addRoute("GET", "/auth/register", "auth/register.php", "auth-register");
Router::addRoute("POST", "/auth/register", "auth/register-action.php", "auth-register-action");
Router::addRoute("GET", "/auth/register/complete", "auth/register-complete.php", "auth-register-complete");
Router::addRoute("GET", "/auth/verify-email", "auth/verify-email.php", "auth-verify-email");
Router::addRoute("GET", "/auth/request-password-recovery", "auth/recovery-request.php", "auth-recovery-request");
Router::addRoute("POST", "/auth/request-password-recovery", "auth/recovery-request-action.php", "auth-recovery-request-action");
Router::addRoute("GET", "/auth/request-password-recovery/complete", "auth/recovery-request-complete.php", "auth-recovery-request-complete");
