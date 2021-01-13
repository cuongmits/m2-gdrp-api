<?php

namespace Cuongmits\GdprApi\Validator;

use Component\Validator\EmailValidator as BaseEmailValidator;
use Cuongmits\GdprApi\Model\GdprGetRequestData;

class EmailValidator implements SingleValidatorInterface
{
    /** @var BaseEmailValidator */
    private $emailValidator;

    public function __construct(BaseEmailValidator $emailValidator)
    {
        $this->emailValidator = $emailValidator;
    }

    public function isValid(GdprGetRequestData $requestData): bool
    {
        $email = $requestData->getEmail();

        return empty($email) || $this->emailValidator->isValid($email);
    }
}
