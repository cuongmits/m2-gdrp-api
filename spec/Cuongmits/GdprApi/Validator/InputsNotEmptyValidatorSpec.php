<?php

namespace spec\Cuongmits\GdprApi\Validator;

use PhpSpec\ObjectBehavior;
use Cuongmits\GdprApi\Model\GdprGetRequestData;
use Cuongmits\GdprApi\Validator\InputsNotEmptyValidator;
use Component\Validator\EmailValidator as BaseEmailValidator;
use Cuongmits\GdprApi\Validator\SingleValidatorInterface;

final class InputsNotEmptyValidatorSpec extends ObjectBehavior
{
    function it_is_initializable(GdprGetRequestData $requestData)
    {
        $this->shouldHaveType(InputsNotEmptyValidator::class);
    }

    function it_should_implements_single_validator_interface()
    {
        $this->shouldImplement(SingleValidatorInterface::class);
    }

    function it_should_return_true_when_at_least_one_input_is_not_empty(GdprGetRequestData $requestData)
    {
        $requestData->getFirstname()->willReturn('');
        $requestData->getLastname()->willReturn('lastname');
        $requestData->getEmail()->willReturn('email');
        $requestData->getSapDebitor()->willReturn('debitor');
        $requestData->getLoyaltyCardNumber()->willReturn('loyalty');

        $this->isValid($requestData)->shouldReturn(true);

        $requestData->getLastname()->willReturn(null);
        $this->isValid($requestData)->shouldReturn(true);

        $requestData->getEmail()->willReturn('');
        $this->isValid($requestData)->shouldReturn(true);

        $requestData->getSapDebitor()->willReturn('');
        $this->isValid($requestData)->shouldReturn(true);
    }

    function it_should_return_false_when_all_inputs_are_empty(
        BaseEmailValidator $emailValidator,
        GdprGetRequestData $requestData
    ) {
        $requestData->getFirstname()->willReturn('');
        $requestData->getLastname()->willReturn('');
        $requestData->getEmail()->willReturn('');
        $requestData->getSapDebitor()->willReturn('');
        $requestData->getLoyaltyCardNumber()->willReturn(null);

        $this->isValid($requestData)->shouldReturn(false);
    }
}
