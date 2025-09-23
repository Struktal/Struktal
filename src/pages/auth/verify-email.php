<?php

// Check whether the user is already logged in
if(Auth->isLoggedIn()) {
    Router->redirect(Router->generate("index"));
}

// Check whether a one-time password has been specified
$validation = Validation->create()
    ->withErrorMessage(t("An error has occurred. Please try again later."))
    ->array()
    ->required()
    ->children([
        "otpid" => \struktal\users\validations\Validations::otpId(),
        "otp" => \struktal\users\validations\Validations::otp()
    ])
    ->build();
try {
    $get = $validation->getValidatedValue($_GET);
} catch(\struktal\validation\ValidationException $e) {
    InfoMessage->error($e->getMessage());
    Router->redirect(Router->generate("auth-login"));
}

$validateVerificationTokenInput = new \struktal\users\dto\ValidateVerificationTokenInputDTO();
$validateVerificationTokenInput->otpId = $get["otpid"];
$validateVerificationTokenInput->otp = $get["otp"];

try {
    $validateVerificationTokenOutput = \struktal\users\services\UserVerificationService::validateVerificationToken($validateVerificationTokenInput);
} catch(\struktal\users\exceptions\InvalidTokenException | \struktal\users\exceptions\UserNotFoundException $e) {
    InfoMessage->error(t("The URL has already been invalidated. Please log in or request a new password recovery email."));
    Router->redirect(Router->generate("auth-login"));
} catch(\Exception $e) {
    InfoMessage->error(t("An error has occurred. Please try again later."));
    Router->redirect(Router->generate("auth-login"));
}

$verifyEmailInput = new \struktal\users\dto\VerifyEmailInputDTO();
$verifyEmailInput->user = $validateVerificationTokenOutput->user;
try {
    \struktal\users\services\UserVerificationService::verifyEmail($verifyEmailInput);
} catch(\Exception $e) {
    InfoMessage->error(t("An error has occurred. Please try again later."));
    Router->redirect(Router->generate("auth-login"));
}

Router->redirect(Router->generate("auth-verify-email-complete"));
