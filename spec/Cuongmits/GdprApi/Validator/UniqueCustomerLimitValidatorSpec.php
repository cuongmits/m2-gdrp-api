<?php

namespace spec\Cuongmits\GdprApi\Validator;

use PhpSpec\ObjectBehavior;
use Cuongmits\GdprApi\Provider\ConfigProvider;
use Cuongmits\GdprApi\Validator\UniqueCustomerLimitValidator;

final class UniqueCustomerLimitValidatorSpec extends ObjectBehavior
{
    function let(ConfigProvider $configProvider)
    {
        $this->beConstructedWith($configProvider);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UniqueCustomerLimitValidator::class);
    }

    function it_should_return_true_when_result_unique_record_number_is_less_than_the_limit(
        ConfigProvider $configProvider
    ) {
        $result = $this->getUniqueCustomerSetsSample();
        $configProvider->getCustomerDataResponseLimit()->willReturn(5);

        $this->isValid($result)->shouldReturn(true);
    }

    function it_should_return_true_when_result_unique_record_number_is_equal_to_the_limit(
        ConfigProvider $configProvider
    ) {
        $result = $this->getUniqueCustomerSetsSample();
        $configProvider->getCustomerDataResponseLimit()->willReturn(4);

        $this->isValid($result)->shouldReturn(true);
    }

    function it_should_return_false_when_result_unique_record_number_is_bigger_than_the_limit(
        ConfigProvider $configProvider
    ) {
        $result = $this->getUniqueCustomerSetsSample();
        $configProvider->getCustomerDataResponseLimit()->willReturn(3);

        $this->isValid($result)->shouldReturn(false);
    }

    private function getUniqueCustomerSetsSample(): array
    {
        return [
            [
                'customer_id' => 1,
                'quote_order_set' => [
                    ['quote_id' => 1, 'order_id' => 1],
                    ['quote_id' => 2, 'order_id' => 2],
                ]
            ],
            [
                'customer_id' => 2,
                'quote_order_set' => [
                    ['quote_id' => 3, 'order_id' => 3],
                ]
            ],
            [
                'customer_id' => 3,
                'quote_order_set' => [
                    ['quote_id' => 4, 'order_id' => 4],
                    ['quote_id' => 7, 'order_id' => ''],
                    ['quote_id' => 8, 'order_id' => ''],
                ]
            ],
            [
                'customer_id' => '',
                'quote_order_set' => [
                    ['quote_id' => 5, 'order_id' => 5],
                    ['quote_id' => 6, 'order_id' => 6],
                ]
            ],
        ];

    }
}
