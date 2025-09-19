<?php

namespace struktal\users\services;

use \struktal\users\dto;
use \struktal\users\uc;

class UserVerificationService {
    public function sendVerificationEmail(dto\SendVerificationEmailInputDTO $input): dto\SendVerificationEmailOutputDTO {
        $useCase = new uc\SendVerificationEmailUC();
        return $useCase->execute($input);
    }

    public function validateVerificationToken(dto\ValidateVerificationTokenInputDTO $input): dto\ValidateVerificationTokenOutputDTO {
        $useCase = new uc\ValidateVerificationTokenUC();
        return $useCase->execute($input);
    }

    public function verifyEmail(dto\VerifyEmailInputDTO $input): dto\VerifyEmailOutputDTO {
        $useCase = new uc\VerifyEmailUC();
        return $useCase->execute($input);
    }

    public function getVerificationStatus(dto\GetVerificationStatusInputDTO $input): dto\GetVerificationStatusOutputDTO {
        $useCase = new uc\GetVerificationStatusUC();
        return $useCase->execute($input);
    }
}
