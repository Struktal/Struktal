<?php

$inputDTO = new \struktal\users\dto\LogoutInputDTO();

try {
    \struktal\users\services\UserService::logout($inputDTO);
} catch(\Exception $e) {
    Logger->tag("Login")->error("An unexpected error occurred during logout of a user: " . $e->getMessage());
    InfoMessage->error(t("An unexpected error occurred. Please try again later."));
    Router->redirect(Router->generate("auth-login"));
}

Router->redirect(Router->generate("index"));
