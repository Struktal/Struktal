<?php

namespace struktal\users\uc;

use \struktal\users\dto;

class RegisterUC implements \UC {
    public function execute(\DTO $input): dto\RegisterOutputDTO {
        if(!($input instanceof dto\RegisterInputDTO)) {
            throw new \IncorrectDTOException();
        }

        $output = new dto\RegisterOutputDTO();

        throw new \RuntimeException("Not implemented yet");
    }
}
