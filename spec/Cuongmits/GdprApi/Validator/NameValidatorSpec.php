<?php

namespace spec\Cuongmits\GdprApi\Validator;

use Cuongmits\GdprApi\Model\GdprGetRequestData;
use PhpSpec\ObjectBehavior;
use Cuongmits\GdprApi\Validator\FullnameLengthValidator;
use Cuongmits\GdprApi\Validator\LastnameValidator;
use Cuongmits\GdprApi\Validator\FirstnameValidator;
use Cuongmits\GdprApi\Validator\NameValidator;
use Cuongmits\GdprApi\Validator\OneEmptyNameValidator;
use Cuongmits\GdprApi\Validator\RequestValidatorInterface;
use Cuongmits\GdprApi\ValidationErrorCode;

final class NameValidatorSpec extends ObjectBehavior
{
    function let(
        FirstnameValidator $firstnameValidator,
        LastnameValidator $lastnameValidator,
        FullnameLengthValidator $fullnameLengthValidator,
        OneEmptyNameValidator $oneEmptyNameValidator,
        GdprGetRequestData $requestData
    ) {
        $firstnameValidator->isValid($requestData)->willReturn(true);
        $lastnameValidator->isValid($requestData)->willReturn(true);
        $fullnameLengthValidator->isValid($requestData)->willReturn(true);
        $oneEmptyNameValidator->isValid($requestData)->willReturn(true);

        $this->beConstructedWith(
            $firstnameValidator,
            $lastnameValidator,
            $fullnameLengthValidator,
            $oneEmptyNameValidator
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(NameValidator::class);
    }

    function it_should_implements_request_validator_interface()
    {
        $this->shouldImplement(RequestValidatorInterface::class);
    }

    function it_should_return_one_empty_name_code_when_one_of_names_is_empty(
        OneEmptyNameValidator $oneEmptyNameValidator,
        GdprGetRequestData $requestData
    ) {
        $oneEmptyNameValidator->isValid($requestData)->willReturn(false);

        $this->getValidErrorCode($requestData)->shouldReturn(ValidationErrorCode::INVALID_ONE_EMPTY_NAME);
    }

    function it_should_return_firstname_code_when_firstname_is_not_valid(
        FirstnameValidator $firstnameValidator,
        GdprGetRequestData $requestData
    ) {
        $firstnameValidator->isValid($requestData)->willReturn(false);

        $this->getValidErrorCode($requestData)->shouldReturn(ValidationErrorCode::INVALID_FIRSTNAME);
    }

    function it_should_return_lastname_code_when_lastname_is_not_valid(
        LastnameValidator $lastnameValidator,
        GdprGetRequestData $requestData
    ) {
        $lastnameValidator->isValid($requestData)->willReturn(false);

        $this->getValidErrorCode($requestData)->shouldReturn(ValidationErrorCode::INVALID_LASTNAME);
    }

    function it_should_return_fullname_code_when_fullname_is_too_long(
        FullnameLengthValidator $fullnameLengthValidator,
        GdprGetRequestData $requestData
    ) {
        $fullnameLengthValidator->isValid($requestData)->willReturn(false);

        $this->getValidErrorCode($requestData)->shouldReturn(ValidationErrorCode::INVALID_FULLNAME);
    }
}
