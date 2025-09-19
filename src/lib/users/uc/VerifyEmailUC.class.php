<?php

namespace struktal\users\uc;

use \struktal\users\dto;

class VerifyEmailUC implements \UC {
    public function execute(\DTO $input): dto\VerifyEmailOutputDTO {
        if(!($input instanceof dto\VerifyEmailInputDTO)) {
            throw new \IncorrectDTOException();
        }

        $output = new dto\VerifyEmailOutputDTO();

        throw new \RuntimeException("Not implemented yet");
    }
}
