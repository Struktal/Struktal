<?php

// Check whether the user is already logged in
if(Auth->isLoggedIn()) {
    Router->redirect(Router->generate("index"));
}

// Check whether form fields are given
$validation = Validation->create()
    ->withErrorMessage(t("Please enter your account's verified email address."))
    ->array()
    ->required()
    ->children([
        "email" => \struktal\users\validations\Validations::email(t("The specified email address is invalid. Please check for spelling errors and try again."))
    ])
    ->build();
try {
    $post = $validation->getValidatedValue($_POST);
} catch(\struktal\validation\ValidationException $e) {
    InfoMessage->error($e->getMessage());
    Router->redirect(Router->generate("auth-recovery-request"));
}

$inputDTO = new \struktal\users\dto\RequestPasswordResetInputDTO();
$inputDTO->email = $post["email"];

try {
    $user = \struktal\users\services\UserPasswordResetService::requestPasswordReset($inputDTO);
} catch(\struktal\users\exceptions\UserNotFoundException | \struktal\users\exceptions\UserNotVerifiedException $e) {
    // We don't reveal whether the email address is registered or not
    Router->redirect(Router->generate("auth-recovery-request-complete"));
} catch(\struktal\users\exceptions\InvalidEmailException $e) {
    InfoMessage->error(t("The specified email address is invalid. Please check for spelling errors and try again."));
    Router->redirect(Router->generate("auth-recovery-request"));
} catch(\Exception $e) {
    Logger->tag("Recovery")->error("An unexpected error occurred during password recovery request for email \"{$post["email"]}\": " . $e->getMessage());
    InfoMessage->error(t("An error has occurred. Please try again later."));
    Router->redirect(Router->generate("auth-recovery-request"));
}

Router->redirect(Router->generate("auth-recovery-request-complete"));
