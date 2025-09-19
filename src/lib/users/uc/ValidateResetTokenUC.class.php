<?php

namespace struktal\users\uc;

use \struktal\users\dto;

class ValidateResetTokenUC implements \UC {
    public function execute(\DTO $input): dto\ValidateResetTokenOutputDTO {
        if(!($input instanceof dto\ValidateResetTokenInputDTO)) {
            throw new \IncorrectDTOException();
        }

        $output = new dto\ValidateResetTokenOutputDTO();

        throw new \RuntimeException("Not implemented yet");
    }
}
