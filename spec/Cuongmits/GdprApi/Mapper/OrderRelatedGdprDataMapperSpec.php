<?php

namespace spec\Cuongmits\GdprApi\Mapper;

use Magento\Framework\App\ResourceConnection;
use Magento\Framework\DB\Adapter\AdapterInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Cuongmits\GdprApi\Mapper\OrderRelatedGdprDataMapper;
use Zend_Db_Statement_Interface;

class OrderRelatedGdprDataMapperSpec extends ObjectBehavior
{
    function let(ResourceConnection $resourceConnection, AdapterInterface $connection)
    {
        $resourceConnection->getConnection()->willReturn($connection);

        $this->beConstructedWith($resourceConnection);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(OrderRelatedGdprDataMapper::class);
    }

    function it_should_return_empty_array_when_map_data_is_empty()
    {
        $this->map(1)->shouldReturn([]);
    }

    function it_should_return_empty_array_when_input_is_null()
    {
        $this->map(null)->shouldReturn([]);
    }

    function it_should_return_correct_data_after_loading_map_data(AdapterInterface $connection, Zend_Db_Statement_Interface $statement)
    {
        $connection->query(Argument::any())->willReturn($statement);
        $connection->getTableName(Argument::any())->willReturn('any table name');
        $statement->fetchAll()->willReturn([
            [
                'order_id' => 1,
                'order_customer_email' => 'email',
                'order_customer_firstname' => 'firstname',
                'order_customer_lastname' => 'lastname',
                'order_remote_ip' => '0.0.0.0',
                'order_x_forwarded_for' => '0.0.0.0',
                'order_sap_debitor' => '111',
                'order_loyalty_card_number' => '222',
                'order_address_address_type' => 'billing',
                'order_address_email' => 'email',
                'order_address_firstname' => 'firstname',
                'order_address_lastname' => 'lastname',
                'order_address_company' => 'company',
                'order_address_street' => 'street',
                'order_address_city' => 'city',
                'order_address_postcode' => 'postcode',
                'order_address_country_id' => 'DE',
                'order_address_telephone' => '12345',
                'order_address_salutation' => 'Herr',
                'order_invoice_id' => 1,
                'order_invoice_toom_invoice_id' => '333',
                'order_invoice_toom_filenet_id' => '444',
                'order_shipment_id' => 1,
                'order_shipment_toom_invoice_id' => '333',
                'order_shipment_track_id' => 1,
                'order_shipment_track_track_number' => '100',
            ],
            [
                'order_id' => 1,
                'order_customer_email' => 'email',
                'order_customer_firstname' => 'firstname',
                'order_customer_lastname' => 'lastname',
                'order_remote_ip' => '0.0.0.0',
                'order_x_forwarded_for' => '0.0.0.0',
                'order_sap_debitor' => '111',
                'order_loyalty_card_number' => '222',
                'order_address_address_type' => 'shipping',
                'order_address_email' => 'email',
                'order_address_firstname' => 'firstname 222',
                'order_address_lastname' => 'lastname 222',
                'order_address_company' => 'company',
                'order_address_street' => 'street',
                'order_address_city' => 'city',
                'order_address_postcode' => 'postcode',
                'order_address_country_id' => 'DE',
                'order_address_telephone' => '12345',
                'order_address_salutation' => 'Herr',
                'order_invoice_id' => 1,
                'order_invoice_toom_invoice_id' => '333',
                'order_invoice_toom_filenet_id' => '444',
                'order_shipment_id' => 1,
                'order_shipment_toom_invoice_id' => '333',
                'order_shipment_track_id' => 2,
                'order_shipment_track_track_number' => '200',
            ],
        ])->shouldBeCalled();

        $this->load([1,2,3]);

        $this->map(1)->shouldContain(["label" => "Email (Order 1)", "value" => "email"]);
        $this->map(1)->shouldContain(["label" => "Firstname (Order 1)", "value" => "firstname"]);
        $this->map(1)->shouldContain(["label" => "Lastname (Order 1)", "value" => "lastname"]);
        $this->map(1)->shouldContain(["label" => "Remote IP (Order 1)", "value" => "0.0.0.0"]);
        $this->map(1)->shouldContain(["label" => "X Forward For (Order 1)", "value" => "0.0.0.0"]);
        $this->map(1)->shouldContain(["label" => "SAP Debitor (Order 1)", "value" => "111"]);
        $this->map(1)->shouldContain(["label" => "Loyalty Card Number (Order 1)", "value" => "222"]);
        $this->map(1)->shouldContain(["label" => "Email (Order 1, billing Address)", "value" => "email"]);
        $this->map(1)->shouldContain(["label" => "Firstname (Order 1, billing Address)", "value" => "firstname"]);
        $this->map(1)->shouldContain(["label" => "Lastname (Order 1, billing Address)", "value" => "lastname"]);
        $this->map(1)->shouldContain(["label" => "Company (Order 1, billing Address)", "value" => "company"]);
        $this->map(1)->shouldContain(["label" => "Street (Order 1, billing Address)", "value" => "street"]);
        $this->map(1)->shouldContain(["label" => "City (Order 1, billing Address)", "value" => "city"]);
        $this->map(1)->shouldContain(["label" => "Postcode (Order 1, billing Address)", "value" => "postcode"]);
        $this->map(1)->shouldContain(["label" => "Country Id (Order 1, billing Address)", "value" => "DE"]);
        $this->map(1)->shouldContain(["label" => "Telephone (Order 1, billing Address)", "value" => "12345"]);
        $this->map(1)->shouldContain(["label" => "Salutation (Order 1, billing Address)", "value" => "Herr"]);
        $this->map(1)->shouldContain(["label" => "Email (Order 1, shipping Address)", "value" => "email"]);
        $this->map(1)->shouldContain(["label" => "Firstname (Order 1, shipping Address)", "value" => "firstname 222"]);
        $this->map(1)->shouldContain(["label" => "Lastname (Order 1, shipping Address)", "value" => "lastname 222"]);
        $this->map(1)->shouldContain(["label" => "Company (Order 1, shipping Address)", "value" => "company"]);
        $this->map(1)->shouldContain(["label" => "Street (Order 1, shipping Address)", "value" => "street"]);
        $this->map(1)->shouldContain(["label" => "City (Order 1, shipping Address)", "value" => "city"]);
        $this->map(1)->shouldContain(["label" => "Postcode (Order 1, shipping Address)", "value" => "postcode"]);
        $this->map(1)->shouldContain(["label" => "Country Id (Order 1, shipping Address)", "value" => "DE"]);
        $this->map(1)->shouldContain(["label" => "Telephone (Order 1, shipping Address)", "value" => "12345"]);
        $this->map(1)->shouldContain(["label" => "Salutation (Order 1, shipping Address)", "value" => "Herr"]);
        $this->map(1)->shouldContain(["label" => "Cuongmits Invoice Id (Order 1, Invoice 1)", "value" => "333"]);
        $this->map(1)->shouldContain(["label" => "Cuongmits Filenet Id (Order 1, Invoice 1)", "value" => "444"]);
        $this->map(1)->shouldContain(["label" => "Cuongmits Invoice Id (Order 1, Shipment 1)", "value" => "333"]);
        $this->map(1)->shouldContain(["label" => "Track number (Order 1, Track 1)", "value" => "100"]);
        $this->map(1)->shouldContain(["label" => "Track number (Order 1, Track 2)", "value" => "200"]);
    }
}
