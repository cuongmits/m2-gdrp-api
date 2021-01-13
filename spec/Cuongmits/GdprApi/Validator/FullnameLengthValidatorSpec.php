<?php

namespace spec\Cuongmits\GdprApi\Validator;

use PhpSpec\ObjectBehavior;
use Cuongmits\GdprApi\Model\GdprGetRequestData;
use Component\Validator\FullnameLengthValidator as BaseFullnameLengthValidator;
use Cuongmits\GdprApi\Validator\FullnameLengthValidator;
use Cuongmits\GdprApi\Validator\SingleValidatorInterface;

final class FullnameLengthValidatorSpec extends ObjectBehavior
{
    function let(BaseFullnameLengthValidator $nameValidator)
    {
        $this->beConstructedWith($nameValidator);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(FullnameLengthValidator::class);
    }

    function it_should_implements_single_validator_interface()
    {
        $this->shouldImplement(SingleValidatorInterface::class);
    }

    function it_should_return_true_when_names_are_empty(GdprGetRequestData $requestData)
    {
        $requestData->getFirstname()->willReturn(null);
        $requestData->getLastname()->willReturn('');

        $this->isValid($requestData)->shouldReturn(true);
    }

    function it_should_return_true_when_names_are_not_empty_and_are_valid(
        BaseFullnameLengthValidator $nameValidator,
        GdprGetRequestData $requestData
    ) {
        $requestData->getFirstname()->willReturn('firstname');
        $requestData->getLastname()->willReturn('lastname');
        $nameValidator->isValid('firstname', 'lastname')->willReturn(true);

        $this->isValid($requestData)->shouldReturn(true);
    }

    function it_should_return_false_when_names_are_not_empty_and_not_valid(
        BaseFullnameLengthValidator $nameValidator,
        GdprGetRequestData $requestData
    ) {
        $requestData->getFirstname()->willReturn('invalid-name');
        $requestData->getLastname()->willReturn('invalid-name');
        $nameValidator->isValid('invalid-name', 'invalid-name')->willReturn(false);

        $this->isValid($requestData)->shouldReturn(false);
    }
}
