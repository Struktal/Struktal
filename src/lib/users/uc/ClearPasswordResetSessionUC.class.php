<?php

namespace app\users\uc;

use \app\users\dto;

class ClearPasswordResetSessionUC implements \UC {
    public function execute(\DTO $input): dto\ClearPasswordResetSessionOutputDTO {
        if(!($input instanceof dto\ClearPasswordResetSessionInputDTO)) {
            throw new \IncorrectDTOException();
        }

        $output = new dto\ClearPasswordResetSessionOutputDTO();

        unset($_SESSION["authRecoveryOtpId"]);
        unset($_SESSION["authRecoveryOtp"]);

        return $output;
    }
}
