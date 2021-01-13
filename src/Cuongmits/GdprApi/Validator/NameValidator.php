<?php

namespace Cuongmits\GdprApi\Validator;

use Cuongmits\GdprApi\Model\GdprGetRequestData;
use Cuongmits\GdprApi\ValidationErrorCode;

class NameValidator implements RequestValidatorInterface
{
    /** @var FirstnameValidator */
    private $firstnameValidator;

    /** @var LastnameValidator */
    private $lastnameValidator;

    /** @var FullnameLengthValidator */
    private $fullnameLengthValidator;

    /** @var OneEmptyNameValidator */
    private $oneEmptyNameValidator;

    public function __construct(
        FirstnameValidator $firstnameValidator,
        LastnameValidator $lastnameValidator,
        FullnameLengthValidator $fullnameLengthValidator,
        OneEmptyNameValidator $oneEmptyNameValidator
    ) {
        $this->firstnameValidator = $firstnameValidator;
        $this->lastnameValidator = $lastnameValidator;
        $this->fullnameLengthValidator = $fullnameLengthValidator;
        $this->oneEmptyNameValidator = $oneEmptyNameValidator;
    }

    public function getValidErrorCode(GdprGetRequestData $requestData): int
    {
        if (!$this->oneEmptyNameValidator->isValid($requestData)) {
            return ValidationErrorCode::INVALID_ONE_EMPTY_NAME;
        }

        if (!$this->firstnameValidator->isValid($requestData)) {
            return ValidationErrorCode::INVALID_FIRSTNAME;
        }

        if (!$this->lastnameValidator->isValid($requestData)) {
            return ValidationErrorCode::INVALID_LASTNAME;
        }

        if (!$this->fullnameLengthValidator->isValid($requestData)) {
            return ValidationErrorCode::INVALID_FULLNAME;
        }

        return ValidationErrorCode::VALID;
    }
}
