<?php

namespace spec\Cuongmits\GdprApi\Mapper;

use Magento\Framework\App\ResourceConnection;
use Magento\Framework\DB\Adapter\AdapterInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Cuongmits\GdprApi\Mapper\QuoteRelatedGdprDataMapper;
use Zend_Db_Statement_Interface;

class QuoteRelatedGdprDataMapperSpec extends ObjectBehavior
{
    function let(ResourceConnection $resourceConnection, AdapterInterface $connection)
    {
        $resourceConnection->getConnection()->willReturn($connection);

        $this->beConstructedWith($resourceConnection);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(QuoteRelatedGdprDataMapper::class);
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
        Zend_Db_Statement_Interface $statement
    ) {
        $connection->query(Argument::any())->willReturn($statement);
        $connection->getTableName(Argument::any())->willReturn('any table name');
        $statement->fetchAll()->willReturn([
            [
                'quote_id' => 1,
                'quote_customer_email' => 'email',
                'quote_customer_firstname' => 'firstname',
                'quote_customer_lastname' => 'lastname',
                'quote_remote_ip' => '0.0.0.0',
                'quote_loyalty_card_number' => '123',
                'quote_address_address_type' => 'billing',
                'quote_address_email' => 'email',
                'quote_address_firstname' => 'firstname',
                'quote_address_lastname' => 'lastname',
                'quote_address_company' => 'company',
                'quote_address_street' => 'street',
                'quote_address_city' => 'city',
                'quote_address_postcode' => 'postcode',
                'quote_address_country_id' => 'DE',
                'quote_address_telephone' => '12345',
                'quote_address_salutation' => 'Herr'
            ],
            [
                'quote_id' => 1,
                'quote_customer_email' => 'email',
                'quote_customer_firstname' => 'firstname',
                'quote_customer_lastname' => 'lastname',
                'quote_remote_ip' => '0.0.0.0',
                'quote_loyalty_card_number' => '123',
                'quote_address_address_type' => 'shipping',
                'quote_address_email' => 'email',
                'quote_address_firstname' => 'firstname 222',
                'quote_address_lastname' => 'lastname 222',
                'quote_address_company' => 'company',
                'quote_address_street' => 'street',
                'quote_address_city' => 'city',
                'quote_address_postcode' => 'postcode',
                'quote_address_country_id' => 'DE',
                'quote_address_telephone' => '12345',
                'quote_address_salutation' => 'Herr'
            ],
        ])->shouldBeCalled();

        $this->load([1,2,3]);

        $this->map(1)->shouldContain(["label" => "Email (Quote 1)", "value" => "email"]);
        $this->map(1)->shouldContain(["label" => "Firstname (Quote 1)", "value" => "firstname"]);
        $this->map(1)->shouldContain(["label" => "Lastname (Quote 1)", "value" => "lastname"]);
        $this->map(1)->shouldContain(["label" => "Remote IP (Quote 1)", "value" => "0.0.0.0"]);
        $this->map(1)->shouldContain(["label" => "Loyalty Card Number (Quote 1)", "value" => "123"]);

        $this->map(1)->shouldContain(["label" => "Email (Quote 1, Billing Address)", "value" => "email"]);
        $this->map(1)->shouldContain(["label" => "Firstname (Quote 1, Billing Address)", "value" => "firstname"]);
        $this->map(1)->shouldContain(["label" => "Lastname (Quote 1, Billing Address)", "value" => "lastname"]);
        $this->map(1)->shouldContain(["label" => "Company (Quote 1, Billing Address)", "value" => "company"]);
        $this->map(1)->shouldContain(["label" => "Street (Quote 1, Billing Address)", "value" => "street"]);
        $this->map(1)->shouldContain(["label" => "City (Quote 1, Billing Address)", "value" => "city"]);
        $this->map(1)->shouldContain(["label" => "Postcode (Quote 1, Billing Address)", "value" => "postcode"]);
        $this->map(1)->shouldContain(["label" => "Country Id (Quote 1, Billing Address)", "value" => "DE"]);
        $this->map(1)->shouldContain(["label" => "Telephone (Quote 1, Billing Address)", "value" => "12345"]);
        $this->map(1)->shouldContain(["label" => "Salutation (Quote 1, Billing Address)", "value" => "Herr"]);

        $this->map(1)->shouldContain(["label" => "Email (Quote 1, Shipping Address)", "value" => "email"]);
        $this->map(1)->shouldContain(["label" => "Firstname (Quote 1, Shipping Address)", "value" => "firstname 222"]);
        $this->map(1)->shouldContain(["label" => "Lastname (Quote 1, Shipping Address)", "value" => "lastname 222"]);
        $this->map(1)->shouldContain(["label" => "Company (Quote 1, Shipping Address)", "value" => "company"]);
        $this->map(1)->shouldContain(["label" => "Street (Quote 1, Shipping Address)", "value" => "street"]);
        $this->map(1)->shouldContain(["label" => "City (Quote 1, Shipping Address)", "value" => "city"]);
        $this->map(1)->shouldContain(["label" => "Postcode (Quote 1, Shipping Address)", "value" => "postcode"]);
        $this->map(1)->shouldContain(["label" => "Country Id (Quote 1, Shipping Address)", "value" => "DE"]);
        $this->map(1)->shouldContain(["label" => "Telephone (Quote 1, Shipping Address)", "value" => "12345"]);
        $this->map(1)->shouldContain(["label" => "Salutation (Quote 1, Shipping Address)", "value" => "Herr"]);
    }
}
