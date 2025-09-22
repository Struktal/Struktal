<?php

namespace struktal\users\services;

use \struktal\users\dto;
use \struktal\users\uc;

class UserPasswordResetService {
    public static function requestPasswordReset(dto\RequestPasswordResetInputDTO $inputDTO): dto\RequestPasswordResetOutputDTO {
        $useCase = new uc\RequestPasswordResetUC();
        return $useCase->execute($inputDTO);
    }

    public static function validateResetToken(dto\ValidateResetTokenInputDTO $input): dto\ValidateResetTokenOutputDTO {
        $useCase = new uc\ValidateResetTokenUC();
        return $useCase->execute($input);
    }

    public static function resetPassword(dto\ResetPasswordInputDTO $input): dto\ResetPasswordOutputDTO {
        $useCase = new uc\ResetPasswordUC();
        return $useCase->execute($input);
    }
}
