<?php

namespace Cuongmits\GdprApi\Validator;

use Component\Validator\NameValidator as BaseNameValidator;
use Cuongmits\GdprApi\Model\GdprGetRequestData;

class LastnameValidator implements SingleValidatorInterface
{
    /** @var BaseNameValidator */
    private $nameValidator;

    public function __construct(BaseNameValidator $nameValidator)
    {
        $this->nameValidator = $nameValidator;
    }

    public function isValid(GdprGetRequestData $requestData): bool
    {
        $lastname = $requestData->getLastname();

        return empty($lastname) || $this->nameValidator->isValid($lastname);
    }
}
