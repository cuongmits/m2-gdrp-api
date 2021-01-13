<?php

namespace Cuongmits\GdprApi\Validator;

use Component\Validator\LoyaltyCardPrefixValidator as BaseLoyaltyCardPrefixValidator;
use Cuongmits\GdprApi\Model\GdprGetRequestData;

class LoyaltyCardPrefixValidator implements SingleValidatorInterface
{
    /** @var BaseLoyaltyCardPrefixValidator */
    private $loyaltyCardPrefixValidator;

    public function __construct(BaseLoyaltyCardPrefixValidator $loyaltyCardPrefixValidator)
    {
        $this->loyaltyCardPrefixValidator = $loyaltyCardPrefixValidator;
    }

    public function isValid(GdprGetRequestData $requestData): bool
    {
        $loyaltyCardNumber = $requestData->getLoyaltyCardNumber();

        return empty($loyaltyCardNumber) || $this->loyaltyCardPrefixValidator->isValid($loyaltyCardNumber);
    }
}
