<?php

namespace struktal\users\uc;

use \struktal\users\dto;

class GetVerificationStatusUC implements \UC {
    public function execute(\DTO $input): dto\GetVerificationStatusOutputDTO {
        if(!($input instanceof dto\GetVerificationStatusInputDTO)) {
            throw new \IncorrectDTOException();
        }

        $output = new dto\GetVerificationStatusOutputDTO();

        throw new \RuntimeException("Not implemented yet");
    }
}
