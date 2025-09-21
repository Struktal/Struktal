<?php

namespace struktal\users\uc;

use \struktal\users\dto;

class LogoutUC implements \UC {
    public function execute(\DTO $input): dto\LogoutOutputDTO {
        if(!($input instanceof dto\LogoutInputDTO)) {
            throw new \IncorrectDTOException();
        }

        $output = new dto\LogoutOutputDTO();

        Auth->logout();

        return $output;
    }
}
