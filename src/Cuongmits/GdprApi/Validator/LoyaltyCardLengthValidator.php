<?php

namespace Cuongmits\GdprApi\Validator;

use Component\Validator\LoyaltyCardLengthValidator as BaseLoyaltyCardLengthValidator;
use Cuongmits\GdprApi\Model\GdprGetRequestData;

class LoyaltyCardLengthValidator implements SingleValidatorInterface
{
    /** @var BaseLoyaltyCardLengthValidator */
    private $loyaltyCardLengthValidator;

    public function __construct(BaseLoyaltyCardLengthValidator $loyaltyCardLengthValidator)
    {
        $this->loyaltyCardLengthValidator = $loyaltyCardLengthValidator;
    }

    public function isValid(GdprGetRequestData $requestData): bool
    {
        $loyaltyCardNumber = $requestData->getLoyaltyCardNumber();

        return empty($loyaltyCardNumber) || $this->loyaltyCardLengthValidator->isValid($loyaltyCardNumber);
    }
}
