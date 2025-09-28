<?php

// Check whether the user is already logged in
if(Auth->isLoggedIn()) {
    Router->redirect(Router->generate("index"));
}

$validatePasswordResetSessionInput = new \app\users\dto\ValidatePasswordResetSessionInputDTO();

try {
    $validatePasswordResetSessionOutput = \app\users\services\UserPasswordResetService::validatePasswordResetSession($validatePasswordResetSessionInput);
} catch(\app\users\exceptions\InvalidTokenException $e) {
    InfoMessage->error(t("An error has occurred. Please try again later."));
    Router->redirect(Router->generate("auth-login"));
} catch(\Exception $e) {
    Logger->tag("Recovery")->error("An unexpected error occurred during password recovery reset validation: " . $e->getMessage());
    InfoMessage->error(t("An error has occurred. Please try again later."));
    Router->redirect(Router->generate("auth-login"));
}

$clearPasswordResetSessionInput = new \app\users\dto\ClearPasswordResetSessionInputDTO();

try {
    \app\users\services\UserPasswordResetService::clearPasswordResetSession($clearPasswordResetSessionInput);
} catch(\Exception $e) {
    Logger->tag("Recovery")->error("An unexpected error occurred during password recovery reset session clearing: " . $e->getMessage());
    InfoMessage->error(t("An error has occurred. Please try again later."));
    Router->redirect(Router->generate("auth-login"));
}

$validatePasswordResetTokenInput = new \app\users\dto\ValidateResetTokenInputDTO();
$validatePasswordResetTokenInput->otpId = $validatePasswordResetSessionOutput->otpId;
$validatePasswordResetTokenInput->otp = $validatePasswordResetSessionOutput->otp;
$validatePasswordResetTokenInput->isUrlEncoded = false;

try {
    $validatePasswordResetTokenOutput = \app\users\services\UserPasswordResetService::validateResetToken($validatePasswordResetTokenInput);
} catch(\app\users\exceptions\InvalidTokenException | \app\users\exceptions\UserNotFoundException $e) {
    InfoMessage->error(t("The URL has already been invalidated. Please log in or request a new password recovery email."));
    Router->redirect(Router->generate("auth-login"));
} catch(\Exception $e) {
    Logger->tag("Recovery")->error("An unexpected error occurred during password recovery reset token validation: " . $e->getMessage());
    InfoMessage->error(t("An error has occurred. Please try again later."));
    Router->redirect(Router->generate("auth-login"));
}

$generatePasswordResetLinkInput = new \app\users\dto\GeneratePasswordResetLinkInputDTO();
$generatePasswordResetLinkInput->user = $validatePasswordResetTokenOutput->user;
$generatePasswordResetLinkInput->otp = $validatePasswordResetTokenOutput->otp;

try {
    $resetLink = \app\users\services\UserPasswordResetService::generatePasswordResetLink($generatePasswordResetLinkInput)->link;
} catch(\Exception $e) {
    Logger->tag("Recovery")->error("An unexpected error occurred during password recovery reset link generation: " . $e->getMessage());
    InfoMessage->error(t("An error has occurred. Please try again later."));
    Router->redirect(Router->generate("auth-login"));
}

// Check whether form fields are given
$postValidation = Validation->create()
    ->withErrorMessage(t("Please fill out all the required fields."))
    ->array()
    ->required()
    ->children([
        "password" => \app\users\validations\Validations::password(),
        "password-repeat" => \app\users\validations\Validations::password()
    ])
    ->build();
try {
    $post = $postValidation->getValidatedValue($_POST);
} catch(\struktal\validation\ValidationException $e) {
    InfoMessage->error($e->getMessage());
    Router->redirect($resetLink);
}

$passwordEditCheckInput = new \app\users\dto\PasswordEditCheckInputDTO();
$passwordEditCheckInput->password = $post["password"];
$passwordEditCheckInput->passwordRepeat = $post["password-repeat"];

try {
    $passwordEditCheckOutput = \app\users\services\PasswordService::passwordEditCheck($passwordEditCheckInput);
} catch(\app\users\exceptions\PasswordMismatchException $e) {
    InfoMessage->error(t("The specified passwords do not match. Please check for spelling errors and try again."));
    Router->redirect($resetLink);
} catch(\app\users\exceptions\WeakPasswordException $e) {
    InfoMessage->error(t("The specified password doesn't fulfill the password requirements. Please choose a safer password."));
    Router->redirect($resetLink);
}

$resetPasswordInput = new \app\users\dto\ResetPasswordInputDTO();
$resetPasswordInput->user = $validatePasswordResetTokenOutput->user;
$resetPasswordInput->password = $passwordEditCheckOutput->password;

try {
    \app\users\services\UserPasswordResetService::resetPassword($resetPasswordInput);
} catch(\Exception $e) {
    Logger->tag("Recovery")->error("An unexpected error occurred during password recovery reset for user with ID \"{$validatePasswordResetTokenOutput->user->getId()}\": " . $e->getMessage());
    InfoMessage->error(t("An error has occurred. Please try again later."));
    Router->redirect($resetLink);
}

Router->redirect(Router->generate("auth-recovery-reset-complete"));
