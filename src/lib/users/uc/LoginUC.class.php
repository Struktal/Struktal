<?php

namespace struktal\users\uc;

use \struktal\users\dto;

class LoginUC implements \UC {
    public function execute(\DTO $input): dto\LoginOutputDTO {
        if(!($input instanceof dto\LoginInputDTO)) {
            throw new \IncorrectDTOException();
        }

        $output = new dto\LoginOutputDTO();

        throw new \RuntimeException("Not implemented yet");
    }
}
