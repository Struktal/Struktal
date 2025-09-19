<?php

namespace struktal\users\services;

use \struktal\users\dto;
use \struktal\users\uc;

class UserVerificationService {
    public function sendVerificationEmail(dto\SendVerificationEmailInputDTO $input): dto\SendVerificationEmailOutputDTO {
        $useCase = new uc\SendVerificationEmailUC();
        return $useCase->execute($input);
    }

    public function checkVerificationToken(dto\CheckVerificationTokenInputDTO $input): dto\CheckVerificationTokenOutputDTO {
        $useCase = new uc\CheckVerificationTokenUC();
        return $useCase->execute($input);
    }

    public function verifyEmail(dto\VerifyEmailInputDTO $input): dto\VerifyEmailOutputDTO {
        $useCase = new uc\VerifyEmailUC();
        return $useCase->execute($input);
    }

    public function checkVerificationStatus(dto\CheckVerificationStatusInputDTO $input): dto\CheckVerificationStatusOutputDTO {
        $useCase = new uc\CheckVerificationStatusUC();
        return $useCase->execute($input);
    }
}
