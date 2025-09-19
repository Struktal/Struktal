<?php

namespace struktal\users\uc;

use \struktal\users\dto;

class RequestPasswordResetUC implements \UC {
    public function execute(\DTO $input): dto\RequestPasswordResetOutputDTO {
        if(!($input instanceof dto\RequestPasswordResetInputDTO)) {
            throw new \IncorrectDTOException();
        }

        $output = new dto\RequestPasswordResetOutputDTO();

        throw new \RuntimeException("Not implemented yet");
    }
}
