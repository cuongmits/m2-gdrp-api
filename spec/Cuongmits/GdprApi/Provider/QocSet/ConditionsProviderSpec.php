<?php

namespace spec\Cuongmits\GdprApi\Provider\QocSet;

use PhpSpec\ObjectBehavior;
use Cuongmits\GdprApi\Model\GdprGetRequestData;
use Cuongmits\GdprApi\Provider\CustomerSetProvider;
use Cuongmits\GdprApi\Provider\QocSet\ConditionsProvider;

class ConditionsProviderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ConditionsProvider::class);
    }

    function it_should_return_null_when_names_are_empty(GdprGetRequestData $requestData)
    {
        $requestData->getFirstname()->willReturn(null);
        $requestData->getLastname()->willReturn(null);

        $this->getQuoteAddressNameCondition($requestData)->shouldReturn(null);
        $this->getQuoteNameCondition($requestData)->shouldReturn(null);
        $this->getOrderNameCondition($requestData)->shouldReturn(null);
        $this->getOrderAddressNameCondition($requestData)->shouldReturn(null);
        $this->getCustomerNameCondition($requestData)->shouldReturn(null);
        $this->getCustomerAddressNameCondition($requestData)->shouldReturn(null);
    }

    function it_should_return_condition_string_when_names_are_not_empty(
        GdprGetRequestData $requestData
    ) {
        $requestData->getFirstname()->willReturn('firstname');
        $requestData->getLastname()->willReturn(null);

        $this->getQuoteAddressNameCondition($requestData)->shouldBeString();
        $this->getQuoteNameCondition($requestData)->shouldBeString();
        $this->getOrderNameCondition($requestData)->shouldBeString();
        $this->getOrderAddressNameCondition($requestData)->shouldBeString();
        $this->getCustomerNameCondition($requestData)->shouldBeString();
        $this->getCustomerAddressNameCondition($requestData)->shouldBeString();

        $requestData->getFirstname()->willReturn(null);
        $requestData->getLastname()->willReturn('lastname');

        $this->getQuoteAddressNameCondition($requestData)->shouldBeString();
        $this->getQuoteNameCondition($requestData)->shouldBeString();
        $this->getOrderNameCondition($requestData)->shouldBeString();
        $this->getOrderAddressNameCondition($requestData)->shouldBeString();
        $this->getCustomerNameCondition($requestData)->shouldBeString();
        $this->getCustomerAddressNameCondition($requestData)->shouldBeString();

        $requestData->getFirstname()->willReturn('firstname');
        $requestData->getLastname()->willReturn('lastname');

        $this->getQuoteAddressNameCondition($requestData)->shouldBeString();
        $this->getQuoteNameCondition($requestData)->shouldBeString();
        $this->getOrderNameCondition($requestData)->shouldBeString();
        $this->getOrderAddressNameCondition($requestData)->shouldBeString();
        $this->getCustomerNameCondition($requestData)->shouldBeString();
        $this->getCustomerAddressNameCondition($requestData)->shouldBeString();
    }

    function it_should_return_null_when_email_is_empty(GdprGetRequestData $requestData)
    {
        $requestData->getEmail()->willReturn(null);

        $this->getQuoteAddressEmailCondition($requestData)->shouldReturn(null);
        $this->getQuoteEmailCondition($requestData)->shouldReturn(null);
        $this->getQuoteAddressEmailCondition($requestData)->shouldReturn(null);
        $this->getOrderEmailCondition($requestData)->shouldReturn(null);
        $this->getOrderAddressEmailCondition($requestData)->shouldReturn(null);
        $this->getCustomerEmailCondition($requestData)->shouldReturn(null);
    }

    function it_should_return_condition_string_when_email_is_not_empty(
        GdprGetRequestData $requestData
    ) {
        $requestData->getEmail()->willReturn('email');

        $this->getQuoteAddressEmailCondition($requestData)->shouldBeString();
        $this->getQuoteEmailCondition($requestData)->shouldBeString();
        $this->getQuoteAddressEmailCondition($requestData)->shouldBeString();
        $this->getOrderEmailCondition($requestData)->shouldBeString();
        $this->getOrderAddressEmailCondition($requestData)->shouldBeString();
        $this->getCustomerEmailCondition($requestData)->shouldBeString();
    }

    function it_should_return_null_when_debitor_number_is_empty(GdprGetRequestData $requestData)
    {
        $requestData->getSapDebitor()->willReturn(null);

        $this->getOrderDebitorNumberCondition($requestData)->shouldReturn(null);
        $this->getCustomerDebitorAttributeCondition($requestData)->shouldReturn(null);
    }

    function it_should_return_condition_string_when_debitor_number_is_not_empty(
        GdprGetRequestData $requestData
    ) {
        $requestData->getSapDebitor()->willReturn('debitor');

        $this->getOrderDebitorNumberCondition($requestData)->shouldBeString();
        $this->getCustomerDebitorAttributeCondition($requestData)->shouldBeString();
    }

    function it_should_return_null_when_loyalty_card_is_empty(GdprGetRequestData $requestData)
    {
        $requestData->getLoyaltyCardNumber()->willReturn(null);

        $this->getQuoteLoyaltyNumberCondition($requestData)->shouldReturn(null);
        $this->getOrderLoyaltyNumberCondition($requestData)->shouldReturn(null);
        $this->getCustomerLoyaltyAttributeCondition($requestData)->shouldReturn(null);
    }

    function it_should_return_condition_string_when_loyalty_card_is_not_empty(
        GdprGetRequestData $requestData
    ) {
        $requestData->getLoyaltyCardNumber()->willReturn('loyalty');

        $this->getQuoteLoyaltyNumberCondition($requestData)->shouldBeString();
        $this->getOrderLoyaltyNumberCondition($requestData)->shouldBeString();
        $this->getCustomerLoyaltyAttributeCondition($requestData)->shouldBeString();
    }
}
