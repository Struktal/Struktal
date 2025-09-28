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
        "otpid" => \app\users\validations\Validations::otpId(),
        "otp" => \app\users\validations\Validations::otp()
    ])
    ->build();
try {
    $get = $validation->getValidatedValue($_GET);
} catch(\struktal\validation\ValidationException $e) {
    InfoMessage->error($e->getMessage());
    Router->redirect(Router->generate("auth-login"));
}

$validateVerificationTokenInput = new \app\users\dto\ValidateVerificationTokenInputDTO();
$validateVerificationTokenInput->otpId = $get["otpid"];
$validateVerificationTokenInput->otp = $get["otp"];

try {
    $validateVerificationTokenOutput = \app\users\services\UserVerificationService::validateVerificationToken($validateVerificationTokenInput);
} catch(\app\users\exceptions\InvalidTokenException | \app\users\exceptions\UserNotFoundException $e) {
    InfoMessage->error(t("The URL has already been invalidated. Please log in or request a new password recovery email."));
    Router->redirect(Router->generate("auth-login"));
} catch(\Exception $e) {
    InfoMessage->error(t("An error has occurred. Please try again later."));
    Router->redirect(Router->generate("auth-login"));
}

$verifyEmailInput = new \app\users\dto\VerifyEmailInputDTO();
$verifyEmailInput->user = $validateVerificationTokenOutput->user;
try {
    \app\users\services\UserVerificationService::verifyEmail($verifyEmailInput);
} catch(\Exception $e) {
    InfoMessage->error(t("An error has occurred. Please try again later."));
    Router->redirect(Router->generate("auth-login"));
}

Router->redirect(Router->generate("auth-verify-email-complete"));
