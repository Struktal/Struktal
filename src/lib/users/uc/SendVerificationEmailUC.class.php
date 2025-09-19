<?php

namespace struktal\users\uc;

use \struktal\users\dto;

class SendVerificationEmailUC implements \UC {
    public function execute(\DTO $input): dto\SendVerificationEmailOutputDTO {
        if(!($input instanceof dto\SendVerificationEmailInputDTO)) {
            throw new \IncorrectDTOException();
        }

        $output = new dto\SendVerificationEmailOutputDTO();

        throw new \RuntimeException("Not implemented yet");
    }
}
