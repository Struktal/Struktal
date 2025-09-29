<?php

namespace app\users\services;

use \app\users\dto;
use \app\users\uc;

class UserPasswordResetService {
    public static function requestPasswordReset(dto\RequestPasswordResetInputDTO $inputDTO): dto\RequestPasswordResetOutputDTO {
        $useCase = new uc\RequestPasswordResetUC();
        return $useCase->execute($inputDTO);
    }

    public static function generatePasswordResetLink(dto\GeneratePasswordResetLinkInputDTO $input): dto\GeneratePasswordResetLinkOutputDTO {
        $useCase = new uc\GeneratePasswordResetLinkUC();
        return $useCase->execute($input);
    }

    public static function validateResetToken(dto\ValidateResetTokenInputDTO $input): dto\ValidateResetTokenOutputDTO {
        $useCase = new uc\ValidateResetTokenUC();
        return $useCase->execute($input);
    }

    public static function resetPassword(dto\ResetPasswordInputDTO $input): dto\ResetPasswordOutputDTO {
        $useCase = new uc\ResetPasswordUC();
        return $useCase->execute($input);
    }

    public static function startPasswordResetSession(dto\StartPasswordResetSessionInputDTO $input): dto\StartPasswordResetSessionOutputDTO {
        $useCase = new uc\StartPasswordResetSessionUC();
        return $useCase->execute($input);
    }

    public static function validatePasswordResetSession(dto\ValidatePasswordResetSessionInputDTO $input): dto\ValidatePasswordResetSessionOutputDTO {
        $useCase = new uc\ValidatePasswordResetSessionUC();
        return $useCase->execute($input);
    }

    public static function clearPasswordResetSession(dto\ClearPasswordResetSessionInputDTO $input): dto\ClearPasswordResetSessionOutputDTO {
        $useCase = new uc\ClearPasswordResetSessionUC();
        return $useCase->execute($input);
    }
}
