<?php

namespace spec\Cuongmits\GdprApi\Validator;

use PhpSpec\ObjectBehavior;
use Cuongmits\GdprApi\Model\GdprGetRequestData;
use Cuongmits\GdprApi\Validator\FirstnameValidator;
use Component\Validator\NameValidator as BaseNameValidator;
use Cuongmits\GdprApi\Validator\SingleValidatorInterface;

final class FirstnameValidatorSpec extends ObjectBehavior
{
    function let(BaseNameValidator $nameValidator)
    {
        $this->beConstructedWith($nameValidator);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(FirstnameValidator::class);
    }

    function it_should_implements_single_validator_interface()
    {
        $this->shouldImplement(SingleValidatorInterface::class);
    }

    function it_should_return_true_when_name_is_empty(GdprGetRequestData $requestData)
    {
        $requestData->getFirstname()->willReturn(null);

        $this->isValid($requestData)->shouldReturn(true);

        $requestData->getFirstname()->willReturn('');

        $this->isValid($requestData)->shouldReturn(true);
    }

    function it_should_return_true_when_name_is_not_empty_and_is_valid(
        BaseNameValidator $nameValidator,
        GdprGetRequestData $requestData
    ) {
        $requestData->getFirstname()->willReturn('Keon');
        $nameValidator->isValid('Keon')->willReturn(true);

        $this->isValid($requestData)->shouldReturn(true);
    }

    function it_should_return_false_when_name_is_not_empty_and_not_valid(
        BaseNameValidator $nameValidator,
        GdprGetRequestData $requestData
    ) {
        $requestData->getFirstname()->willReturn('invalid-name');
        $nameValidator->isValid('invalid-name')->willReturn(false);

        $this->isValid($requestData)->shouldReturn(false);
    }
}
