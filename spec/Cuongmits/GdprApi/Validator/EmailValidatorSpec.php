<?php

namespace spec\Cuongmits\GdprApi\Validator;

use PhpSpec\ObjectBehavior;
use Cuongmits\GdprApi\Model\GdprGetRequestData;
use Cuongmits\GdprApi\Validator\EmailValidator;
use Component\Validator\EmailValidator as BaseEmailValidator;
use Cuongmits\GdprApi\Validator\SingleValidatorInterface;

final class EmailValidatorSpec extends ObjectBehavior
{
    function let(BaseEmailValidator $emailValidator)
    {
        $this->beConstructedWith($emailValidator);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(EmailValidator::class);
    }

    function it_should_implements_single_validator_interface()
    {
        $this->shouldImplement(SingleValidatorInterface::class);
    }

    function it_should_return_true_when_email_is_empty(GdprGetRequestData $requestData)
    {
        $requestData->getEmail()->willReturn('');

        $this->isValid($requestData)->shouldReturn(true);
    }

    function it_should_return_true_when_email_is_not_empty_and_is_valid(
        BaseEmailValidator $emailValidator,
        GdprGetRequestData $requestData
    ) {
        $requestData->getEmail()->willReturn('valid@email.com');
        $emailValidator->isValid('valid@email.com')->willReturn(true);

        $this->isValid($requestData)->shouldReturn(true);
    }

    function it_should_return_false_when_email_is_not_empty_and_not_valid(
        BaseEmailValidator $emailValidator,
        GdprGetRequestData $requestData
    ) {
        $requestData->getEmail()->willReturn('invalid@email');
        $emailValidator->isValid('invalid@email')->willReturn(false);

        $this->isValid($requestData)->shouldReturn(false);
    }
}
