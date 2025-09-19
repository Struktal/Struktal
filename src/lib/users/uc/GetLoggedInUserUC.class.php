<?php

namespace struktal\users\uc;

use \struktal\users\dto;

class GetLoggedInUserUC implements \UC {
    public function execute(\DTO $input): dto\GetLoggedInUserOutputDTO {
        if(!($input instanceof dto\GetLoggedInUserInputDTO)) {
            throw new \IncorrectDTOException();
        }

        $output = new dto\GetLoggedInUserOutputDTO();

        throw new \RuntimeException("Not implemented yet");
    }
}
