<?php

namespace struktal\users\uc;

use \struktal\users\dto;

class ValidateVerificationTokenUC implements \UC {
    public function execute(\DTO $input): dto\ValidateVerificationTokenOutputDTO {
        if(!($input instanceof dto\ValidateVerificationTokenInputDTO)) {
            throw new \IncorrectDTOException();
        }

        $output = new dto\ValidateVerificationTokenOutputDTO();

        throw new \RuntimeException("Not implemented yet");
    }
}
