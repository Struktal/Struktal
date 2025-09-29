<?php

namespace app\users\uc;

use \app\users\dto;

class GetLoggedInUserUC implements \UC {
    public function execute(\DTO $input): dto\GetLoggedInUserOutputDTO {
        if(!($input instanceof dto\GetLoggedInUserInputDTO)) {
            throw new \IncorrectDTOException();
        }

        $output = new dto\GetLoggedInUserOutputDTO();

        $user = Auth->getLoggedInUser();
        if($user instanceof \app\users\orm\User) {
            $output->user = $user;
        } else {
            $output->user = null;
        }

        return $output;
    }
}
