<?php

namespace spec\Cuongmits\GdprApi\Validator;

use Cuongmits\GdprApi\Model\GdprGetRequestData;
use Cuongmits\GdprApi\Validator\GetRequestValidator;
use Cuongmits\GdprApi\Validator\InputsNotEmptyValidator;
use PhpSpec\ObjectBehavior;
use Cuongmits\GdprApi\Validator\EmailValidator;
use Cuongmits\GdprApi\Validator\LoyaltyCardPrefixValidator;
use Cuongmits\GdprApi\Validator\LoyaltyCardLengthValidator;
use Cuongmits\GdprApi\Validator\RequestValidatorInterface;
use Cuongmits\GdprApi\Validator\NameValidator;
use Cuongmits\GdprApi\ValidationErrorCode;

final class GetRequestValidatorSpec extends ObjectBehavior
{
    function let(
        NameValidator $nameValidator,
        EmailValidator $emailValidator,
        LoyaltyCardPrefixValidator $loyaltyCardPrefixValidator,
        LoyaltyCardLengthValidator $loyaltyCardLengthValidator,
        InputsNotEmptyValidator $inputsNotEmptyValidator,
        GdprGetRequestData $requestData
    ) {
        $inputsNotEmptyValidator->isValid($requestData)->willReturn(true);
        $nameValidator->getValidErrorCode($requestData)->willReturn(ValidationErrorCode::VALID);
        $emailValidator->isValid($requestData)->willReturn(true);
        $loyaltyCardLengthValidator->isValid($requestData)->willReturn(true);
        $loyaltyCardPrefixValidator->isValid($requestData)->willReturn(true);

        $this->beConstructedWith(
            $nameValidator,
            $emailValidator,
            $loyaltyCardPrefixValidator,
            $loyaltyCardLengthValidator,
            $inputsNotEmptyValidator
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(GetRequestValidator::class);
    }

    function it_should_implements_request_validator_interface()
    {
        $this->shouldImplement(RequestValidatorInterface::class);
    }

    function it_should_return_all_empty_inputs_code_when_all_inputs_are_empty(
        InputsNotEmptyValidator $inputsNotEmptyValidator,
        GdprGetRequestData $requestData
    ) {
        $inputsNotEmptyValidator->isValid($requestData)->willReturn(false);

        $this->getValidErrorCode($requestData)->shouldReturn(ValidationErrorCode::INVALID_ALL_EMPTY_INPUTS);
    }

    function it_should_return_error_name_code_when_name_contains_error(
        NameValidator $nameValidator,
        GdprGetRequestData $requestData
    ) {
        $anyNameErrorCode = 999;
        $nameValidator->getValidErrorCode($requestData)->willReturn($anyNameErrorCode);

        $this->getValidErrorCode($requestData)->shouldReturn($anyNameErrorCode);
    }

    function it_should_return_email_code_when_email_is_not_valid(
        EmailValidator $emailValidator,
        GdprGetRequestData $requestData
    ) {
        $emailValidator->isValid($requestData)->willReturn(false);

        $this->getValidErrorCode($requestData)->shouldReturn(ValidationErrorCode::INVALID_EMAIL);
    }

    function it_should_return_loyalty_card_prefix_code_when_it_has_not_correct_prefix(
        LoyaltyCardPrefixValidator $loyaltyCardPrefixValidator,
        GdprGetRequestData $requestData
    ) {
        $loyaltyCardPrefixValidator->isValid($requestData)->willReturn(false);

        $this->getValidErrorCode($requestData)->shouldReturn(ValidationErrorCode::INVALID_LOYALTY_CARD_PREFIX);
    }

    function it_should_return_loyalty_card_length_code_when_it_is_too_long(
        LoyaltyCardLengthValidator $loyaltyCardLengthValidator,
        GdprGetRequestData $requestData
    ) {
        $loyaltyCardLengthValidator->isValid($requestData)->willReturn(false);

        $this->getValidErrorCode($requestData)->shouldReturn(ValidationErrorCode::INVALID_LOYALTY_CARD_LENGTH);
    }

    function it_should_return_valid_code_when_all_inputs_are_valid(GdprGetRequestData $requestData)
    {
        $this->getValidErrorCode($requestData)->shouldReturn(ValidationErrorCode::VALID);
    }
}
