<?php

namespace spec\Cuongmits\GdprApi\Mapper;

use Magento\Eav\Model\ResourceModel\Entity\Attribute;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Prophecy\Argument;
use Cuongmits\CustomerAddressAttribute;
use Cuongmits\CustomerAttribute;
use Cuongmits\GdprApi\Mapper\CustomerRelatedGdprDataMapper;
use PhpSpec\ObjectBehavior;
use Zend_Db_Statement_Interface;

class CustomerRelatedGdprDataMapperSpec extends ObjectBehavior
{
    function let(ResourceConnection $resourceConnection, Attribute $attributeResource, AdapterInterface $connection)
    {
        $resourceConnection->getConnection()->willReturn($connection);

        $this->beConstructedWith($resourceConnection, $attributeResource);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CustomerRelatedGdprDataMapper::class);
    }

    function it_should_return_empty_array_when_map_data_is_empty()
    {
        $this->map(1)->shouldReturn([]);
    }

    function it_should_return_empty_array_when_input_is_null()
    {
        $this->map(null)->shouldReturn([]);
    }

    function it_should_return_correct_data_after_loading_map_data(
        AdapterInterface $connection,
        Attribute $attributeResource,
        Zend_Db_Statement_Interface $statement
    ) {
        $connection->getTableName(Argument::any())->willReturn('any table name');
        $attributeResource->getIdByCode(Argument::any(), CustomerAttribute::SAP_DEBITOR)->willReturn(1);
        $attributeResource->getIdByCode(Argument::any(), CustomerAttribute::LOYALTY_CARD)->willReturn(2);
        $attributeResource->getIdByCode(Argument::any(), CustomerAddressAttribute::ADDRESS_TYPE)->willReturn(3);
        $connection->query(Argument::any(), Argument::any())->willReturn($statement);

        $statement->fetchAll()->willReturn([
            [
                'customer_id' => 1,
                'customer_email' => 'email',
                'customer_firstname' => 'firstname',
                'customer_lastname' => 'lastname',
                'customer_sap_debitor' => '11111',
                'customer_loyalty_card_number' => '22222',
                'customer_address_id' => 1,
                'customer_address_city' => 'city',
                'customer_address_company' => 'company',
                'customer_address_country_id' => 'DE',
                'customer_address_firstname' => 'firstname',
                'customer_address_lastname' => 'lastname',
                'customer_address_postcode' => '12345',
                'customer_address_street' => 'street',
                'customer_address_telephone' => '0123456789',
                'customer_address_salutation' => 'Herr',
                'customer_address_address_type' => 'billing'
            ],
            [
                'customer_id' => 1,
                'customer_email' => 'email',
                'customer_firstname' => 'firstname',
                'customer_lastname' => 'lastname',
                'customer_sap_debitor' => '11111',
                'customer_loyalty_card_number' => '22222',
                'customer_address_id' => 2,
                'customer_address_city' => 'city',
                'customer_address_company' => 'company',
                'customer_address_country_id' => 'DE',
                'customer_address_firstname' => 'firstname',
                'customer_address_lastname' => 'lastname',
                'customer_address_postcode' => '12345',
                'customer_address_street' => 'street',
                'customer_address_telephone' => '0123456789',
                'customer_address_salutation' => 'Herr',
                'customer_address_address_type' => 'shipping'
            ],
        ])->shouldBeCalled();

        $this->load([1,2,3]);

        $this->map(1)->shouldContain(["label" => "Email (Customer 1)", "value" => "email"]);
        $this->map(1)->shouldContain(["label" => "Firstname (Customer 1)", "value" => "firstname"]);
        $this->map(1)->shouldContain(["label" => "Lastname (Customer 1)", "value" => "lastname"]);
        $this->map(1)->shouldContain(["label" => "SAP Debitor (Customer 1)", "value" => "11111"]);
        $this->map(1)->shouldContain(["label" => "Loyalty Card Number (Customer 1)", "value" => "22222"]);

        $this->map(1)->shouldContain(["label" => "City (Customer 1, Billing Address 1)", "value" => "city"]);
        $this->map(1)->shouldContain(["label" => "Company (Customer 1, Billing Address 1)", "value" => "company"]);
        $this->map(1)->shouldContain(["label" => "Country Id (Customer 1, Billing Address 1)", "value" => "DE"]);
        $this->map(1)->shouldContain(["label" => "Firstname (Customer 1, Billing Address 1)", "value" => "firstname"]);
        $this->map(1)->shouldContain(["label" => "Lastname (Customer 1, Billing Address 1)", "value" => "lastname"]);
        $this->map(1)->shouldContain(["label" => "Postcode (Customer 1, Billing Address 1)", "value" => "12345"]);
        $this->map(1)->shouldContain(["label" => "Street (Customer 1, Billing Address 1)", "value" => "street"]);
        $this->map(1)->shouldContain(["label" => "Telephone (Customer 1, Billing Address 1)", "value" => "0123456789"]);
        $this->map(1)->shouldContain(["label" => "Salutation (Customer 1, Billing Address 1)", "value" => "Herr"]);

        $this->map(1)->shouldContain(["label" => "City (Customer 1, Shipping Address 2)", "value" => "city"]);
        $this->map(1)->shouldContain(["label" => "Company (Customer 1, Shipping Address 2)", "value" => "company"]);
        $this->map(1)->shouldContain(["label" => "Country Id (Customer 1, Shipping Address 2)", "value" => "DE"]);
        $this->map(1)->shouldContain(["label" => "Firstname (Customer 1, Shipping Address 2)", "value" => "firstname"]);
        $this->map(1)->shouldContain(["label" => "Lastname (Customer 1, Shipping Address 2)", "value" => "lastname"]);
        $this->map(1)->shouldContain(["label" => "Postcode (Customer 1, Shipping Address 2)", "value" => "12345"]);
        $this->map(1)->shouldContain(["label" => "Street (Customer 1, Shipping Address 2)", "value" => "street"]);
        $this->map(1)->shouldContain(["label" => "Telephone (Customer 1, Shipping Address 2)", "value" => "0123456789"]);
        $this->map(1)->shouldContain(["label" => "Salutation (Customer 1, Shipping Address 2)", "value" => "Herr"]);
    }
}
