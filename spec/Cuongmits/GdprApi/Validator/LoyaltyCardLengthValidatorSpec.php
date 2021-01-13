<?php

namespace spec\Cuongmits\GdprApi\Validator;

use PhpSpec\ObjectBehavior;
use Component\Validator\LoyaltyCardLengthValidator as BaseLoyaltyCardLengthValidator;
use Cuongmits\GdprApi\Model\GdprGetRequestData;
use Cuongmits\GdprApi\Validator\LoyaltyCardLengthValidator;
use Cuongmits\GdprApi\Validator\SingleValidatorInterface;

final class LoyaltyCardLengthValidatorSpec extends ObjectBehavior
{
    function let(BaseLoyaltyCardLengthValidator $loyaltyCardLengthValidator)
    {
        $this->beConstructedWith($loyaltyCardLengthValidator);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(LoyaltyCardLengthValidator::class);
    }

    function it_should_implements_single_validator_interface()
    {
        $this->shouldImplement(SingleValidatorInterface::class);
    }

    function it_should_return_true_when_loyalty_card_is_empty(GdprGetRequestData $requestData)
    {
        $requestData->getLoyaltyCardNumber()->willReturn(null);

        $this->isValid($requestData)->shouldReturn(true);

        $requestData->getLoyaltyCardNumber()->willReturn('');

        $this->isValid($requestData)->shouldReturn(true);
    }

    function it_should_return_true_when_loyalty_card_is_not_empty_and_is_valid(
        BaseLoyaltyCardLengthValidator $loyaltyCardLengthValidator,
        GdprGetRequestData $requestData
    ) {
        $requestData->getLoyaltyCardNumber()->willReturn('valid-loyalty-card');
        $loyaltyCardLengthValidator->isValid('valid-loyalty-card')->willReturn(true);

        $this->isValid($requestData)->shouldReturn(true);
    }

    function it_should_return_false_when_loyalty_card_is_not_empty_and_not_valid(
        BaseLoyaltyCardLengthValidator $loyaltyCardLengthValidator,
        GdprGetRequestData $requestData
    ) {
        $requestData->getLoyaltyCardNumber()->willReturn('invalid-loyalty-card');
        $loyaltyCardLengthValidator->isValid('invalid-loyalty-card')->willReturn(false);

        $this->isValid($requestData)->shouldReturn(false);
    }
}
