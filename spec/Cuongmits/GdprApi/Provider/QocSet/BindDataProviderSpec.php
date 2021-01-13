<?php

namespace spec\Cuongmits\GdprApi\Provider\QocSet;

use Magento\Eav\Model\ResourceModel\Entity\Attribute;
use PhpSpec\ObjectBehavior;
use Cuongmits\CustomerAttribute;
use Cuongmits\GdprApi\Model\GdprGetRequestData;
use Cuongmits\GdprApi\Provider\CustomerSetProvider;
use Cuongmits\GdprApi\Provider\QocSet\BindDataProvider;

class BindDataProviderSpec extends ObjectBehavior
{
    function let(Attribute $attributeResource, GdprGetRequestData $requestData)
    {
        $requestData->getFirstname()->willReturn('firstname');
        $requestData->getLastname()->willReturn('lastname');
        $requestData->getEmail()->willReturn('email');
        $requestData->getSapDebitor()->willReturn('sap debitor');
        $requestData->getLoyaltyCardNumber()->willReturn('loyalty');

        $attributeResource->getIdByCode('customer', CustomerAttribute::SAP_DEBITOR)->willReturn(1);
        $attributeResource->getIdByCode('customer', CustomerAttribute::LOYALTY_CARD)->willReturn(2);

        $this->beConstructedWith($attributeResource);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(BindDataProvider::class);
    }

    function it_should_return_array_with_all_values(GdprGetRequestData $requestData)
    {
        $this->getBindData($requestData)->shouldReturn([
            'first_name' => 'firstname',
            'last_name' => 'lastname',
            'email' => 'email',
            'debitor_attr_id' => 1,
            'sap_debitor' => 'sap debitor',
            'loyalty_attr_id' => 2,
            'loyalty_card_number' => 'loyalty'
        ]);
    }

    function it_should_remove_null_values_from_full_array_result(GdprGetRequestData $requestData)
    {
        $requestData->getFirstname()->willReturn(null);
        $this->getBindData($requestData)->shouldNotHaveKey('first_name');

        $requestData->getLastname()->willReturn(null);
        $this->getBindData($requestData)->shouldNotHaveKey('last_name');

        $requestData->getEmail()->willReturn(null);
        $this->getBindData($requestData)->shouldNotHaveKey('email');

        $requestData->getSapDebitor()->willReturn(null);
        $this->getBindData($requestData)->shouldNotHaveKey('debitor_attr_id');
        $this->getBindData($requestData)->shouldNotHaveKey('sap_debitor');

        $requestData->getLoyaltyCardNumber()->willReturn(null);
        $this->getBindData($requestData)->shouldNotHaveKey('loyalty_attr_id');
        $this->getBindData($requestData)->shouldNotHaveKey('loyalty_card_number');
    }
}
