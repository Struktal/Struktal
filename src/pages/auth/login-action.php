<?php

// Check whether the user is already logged in
if(Auth->isLoggedIn()) {
    Router->redirect(Router->generate("index"));
}

// Check whether form fields are given
$validation = Validation->create()
    ->withErrorMessage(t("Please log in with your account's credentials."))
    ->array()
    ->required()
    ->children([
        "username" => \struktal\users\validations\Validations::username(),
        "password" => \struktal\users\validations\Validations::password()
    ])
    ->build();
try {
    $post = $validation->getValidatedValue($_POST);
} catch(\struktal\validation\ValidationException $e) {
    InfoMessage->error($e->getMessage());
    Router->redirect(Router->generate("auth-login"));
}

$input = new \struktal\users\dto\LoginInputDTO();
$input->login = $post["username"];
$input->loginWithEmail = false;
$input->password = $post["password"];

try {
    \struktal\users\services\UserService::login($input);
} catch(\struktal\users\exceptions\UserNotFoundException | \struktal\users\exceptions\InvalidPasswordException $e) {
    InfoMessage->error(t("An account with these credentials could not be found. Please check for spelling errors and try again."));
    Router->redirect(Router->generate("auth-login"));
} catch(\struktal\users\exceptions\UserNotVerifiedException $e) {
    InfoMessage->error(t("Before logging in, please verify your account's email address."));
    Router->redirect(Router->generate("auth-login"));
} catch(\Exception $e) {
    Logger->tag("Login")->error("An unexpected error occurred during login of user \"{$post["username"]}\": " . $e->getMessage());
    InfoMessage->error(t("An unexpected error occurred. Please try again later."));
    Router->redirect(Router->generate("auth-login"));
}

Router->redirect(Router->generate("index"));
