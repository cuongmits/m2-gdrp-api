<?php

namespace Cuongmits\GdprApi\Validator;

use Cuongmits\GdprApi\Model\GdprGetRequestData;
use Component\Validator\FullnameLengthValidator as BaseFullnameLengthValidator;

class FullnameLengthValidator implements SingleValidatorInterface
{
    /** @var BaseFullnameLengthValidator */
    private $fullnameLengthValidator;

    public function __construct(BaseFullnameLengthValidator $fullnameLengthValidator)
    {
        $this->fullnameLengthValidator = $fullnameLengthValidator;
    }

    public function isValid(GdprGetRequestData $requestData): bool
    {
        $firstname = $requestData->getFirstname();
        $lastname = $requestData->getLastname();

        return (empty($firstname) && empty($lastname))
            || $this->fullnameLengthValidator->isValid($firstname, $lastname);
    }
}
