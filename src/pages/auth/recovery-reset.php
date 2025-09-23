<?php

// Check whether the user is already logged in
if(Auth->isLoggedIn()) {
    Router->redirect(Router->generate("index"));
}

// Clear old session variables
unset($_SESSION["authRecoveryOtpId"]);
unset($_SESSION["authRecoveryOtp"]);

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

$validateResetTokenInput = new \struktal\users\dto\ValidateResetTokenInputDTO();
$validateResetTokenInput->otpId = $get["otpid"];
$validateResetTokenInput->otp = $get["otp"];
$validateResetTokenInput->isUrlEncoded = true;

try {
    $validateResetTokenOutput = \struktal\users\services\UserPasswordResetService::validateResetToken($validateResetTokenInput);
} catch(\struktal\users\exceptions\InvalidTokenException | \struktal\users\exceptions\UserNotFoundException $e) {
    InfoMessage->error(t("The URL has already been invalidated. Please log in or request a new password recovery email."));
    Router->redirect(Router->generate("auth-login"));
} catch(\Exception $e) {
    InfoMessage->error(t("An error has occurred. Please try again later."));
    Router->redirect(Router->generate("auth-login"));
}

$startPasswordResetSessionInput = new \struktal\users\dto\StartPasswordResetSessionInputDTO();
$startPasswordResetSessionInput->user = $validateResetTokenOutput->user;
$startPasswordResetSessionInput->otp = $validateResetTokenOutput->otp;

try {
    $startPasswordResetSessionOutput = \struktal\users\services\UserPasswordResetService::startPasswordResetSession($startPasswordResetSessionInput);
} catch(\Exception $e) {
    InfoMessage->error(t("An error has occurred. Please try again later."));
    Router->redirect(Router->generate("auth-login"));
}

echo Blade->run("pages.auth.recoveryreset");
