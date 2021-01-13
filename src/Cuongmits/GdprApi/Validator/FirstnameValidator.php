<?php

namespace Cuongmits\GdprApi\Validator;

use Component\Validator\NameValidator as BaseNameValidator;
use Cuongmits\GdprApi\Model\GdprGetRequestData;

class FirstnameValidator implements SingleValidatorInterface
{
    /** @var BaseNameValidator */
    private $nameValidator;

    public function __construct(BaseNameValidator $nameValidator)
    {
        $this->nameValidator = $nameValidator;
    }

    public function isValid(GdprGetRequestData $requestData): bool
    {
        $firstname = $requestData->getFirstname();

        return empty($firstname) || $this->nameValidator->isValid($firstname);
    }
}
