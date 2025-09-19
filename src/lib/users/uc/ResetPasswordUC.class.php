<?php

namespace struktal\users\uc;

use \struktal\users\dto;

class ResetPasswordUC implements \UC {
    public function execute(\DTO $input): dto\ResetPasswordOutputDTO {
        if(!($input instanceof dto\ResetPasswordInputDTO)) {
            throw new \IncorrectDTOException();
        }

        $output = new dto\ResetPasswordOutputDTO();

        throw new \RuntimeException("Not implemented yet");
    }
}
