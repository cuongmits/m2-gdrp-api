<?php

namespace Cuongmits\GdprApi\Validator;

use Cuongmits\GdprApi\Model\GdprGetRequestData;

class InputsNotEmptyValidator implements SingleValidatorInterface
{
    public function isValid(GdprGetRequestData $requestData): bool
    {
        return !empty($requestData->getFirstname())
            || !empty($requestData->getLastname())
            || !empty($requestData->getEmail())
            || !empty($requestData->getSapDebitor())
            || !empty($requestData->getLoyaltyCardNumber());
    }
}
