<?php

namespace spec\Cuongmits\GdprApi\Validator;

use PhpSpec\ObjectBehavior;
use Cuongmits\GdprApi\Model\GdprGetRequestData;
use Cuongmits\GdprApi\Validator\LoyaltyCardPrefixValidator;
use Component\Validator\LoyaltyCardPrefixValidator as BaseLoyaltyCardPrefixValidator;
use Cuongmits\GdprApi\Validator\SingleValidatorInterface;

final class LoyaltyCardPrefixValidatorSpec extends ObjectBehavior
{
    function let(BaseLoyaltyCardPrefixValidator $loyaltyCardPrefixValidator)
    {
        $this->beConstructedWith($loyaltyCardPrefixValidator);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(LoyaltyCardPrefixValidator::class);
    }

    function it_should_implements_single_validator_interface()
    {
        $this->shouldImplement(SingleValidatorInterface::class);
    }

    function it_should_return_true_when_name_is_empty(GdprGetRequestData $requestData)
    {
        $requestData->getLoyaltyCardNumber()->willReturn(null);

        $this->isValid($requestData)->shouldReturn(true);

        $requestData->getLoyaltyCardNumber()->willReturn('');

        $this->isValid($requestData)->shouldReturn(true);
    }

    function it_should_return_true_when_loyalty_card_is_not_empty_and_is_valid(
        BaseLoyaltyCardPrefixValidator $loyaltyCardPrefixValidator,
        GdprGetRequestData $requestData
    ) {
        $requestData->getLoyaltyCardNumber()->willReturn('valid-loyalty-card');
        $loyaltyCardPrefixValidator->isValid('valid-loyalty-card')->willReturn(true);

        $this->isValid($requestData)->shouldReturn(true);
    }

    function it_should_return_false_when_loyalty_card_is_not_empty_and_not_valid(
        BaseLoyaltyCardPrefixValidator $loyaltyCardPrefixValidator,
        GdprGetRequestData $requestData
    ) {
        $requestData->getLoyaltyCardNumber()->willReturn('invalid-loyalty-card');
        $loyaltyCardPrefixValidator->isValid('invalid-loyalty-card')->willReturn(false);

        $this->isValid($requestData)->shouldReturn(false);
    }
}
