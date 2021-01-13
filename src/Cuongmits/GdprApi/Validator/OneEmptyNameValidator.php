<?php

namespace Cuongmits\GdprApi\Validator;

use Cuongmits\GdprApi\Model\GdprGetRequestData;

class OneEmptyNameValidator implements SingleValidatorInterface
{
    public function isValid(GdprGetRequestData $requestData): bool
    {
        return !(empty($requestData->getFirstname()) xor empty($requestData->getLastname()));
    }
}
