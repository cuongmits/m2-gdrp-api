<?php

namespace Cuongmits\GdprApi\Validator;

use Cuongmits\GdprApi\Model\GdprGetRequestData;
use Cuongmits\GdprApi\ValidationErrorCode;

class GetRequestValidator implements RequestValidatorInterface
{
    /** @var EmailValidator */
    private $emailValidator;

    /** @var LoyaltyCardPrefixValidator */
    private $loyaltyCardPrefixValidator;

    /** @var LoyaltyCardLengthValidator */
    private $loyaltyCardLengthValidator;

    /** @var InputsNotEmptyValidator */
    private $inputsNotEmptyValidator;

    /** @var NameValidator */
    private $nameValidator;

    public function __construct(
        NameValidator $nameValidator,
        EmailValidator $emailValidator,
        LoyaltyCardPrefixValidator $loyaltyCardPrefixValidator,
        LoyaltyCardLengthValidator $loyaltyCardLengthValidator,
        InputsNotEmptyValidator $inputsNotEmptyValidator
    ) {
        $this->emailValidator = $emailValidator;
        $this->loyaltyCardPrefixValidator = $loyaltyCardPrefixValidator;
        $this->loyaltyCardLengthValidator = $loyaltyCardLengthValidator;
        $this->inputsNotEmptyValidator = $inputsNotEmptyValidator;
        $this->nameValidator = $nameValidator;
    }

    public function getValidErrorCode(GdprGetRequestData $requestData): int
    {
        if (!$this->inputsNotEmptyValidator->isValid($requestData)) {
            return ValidationErrorCode::INVALID_ALL_EMPTY_INPUTS;
        }

        $nameErrorCode = $this->nameValidator->getValidErrorCode($requestData);
        if ($nameErrorCode !== ValidationErrorCode::VALID) {
            return $nameErrorCode;
        }

        if (!$this->emailValidator->isValid($requestData)) {
            return ValidationErrorCode::INVALID_EMAIL;
        }

        if (!$this->loyaltyCardPrefixValidator->isValid($requestData)) {
            return ValidationErrorCode::INVALID_LOYALTY_CARD_PREFIX;
        }

        if (!$this->loyaltyCardLengthValidator->isValid($requestData)) {
            return ValidationErrorCode::INVALID_LOYALTY_CARD_LENGTH;
        }

        return ValidationErrorCode::VALID;
    }
}
