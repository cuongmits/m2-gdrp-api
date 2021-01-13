<?php

namespace spec\Cuongmits\GdprApi\Provider;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Cuongmits\GdprApi\Provider\ConfigProvider;
use PhpSpec\ObjectBehavior;

class ConfigProviderSpec extends ObjectBehavior
{
    function let(ScopeConfigInterface $scopeConfig)
    {
        $this->beConstructedWith($scopeConfig);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ConfigProvider::class);
    }

    function it_should_return_default_customer_data_response_limit_when_it_is_not_set_on_admin(
        ScopeConfigInterface $scopeConfig
    ) {
        $scopeConfig->getValue(ConfigProvider::CUSTOMER_DATA_RESPONSE_LIMIT)->willReturn(null);

        $this->getCustomerDataResponseLimit()->shouldReturn(ConfigProvider::DEFAULT_CUSTOMER_DATA_RESPONSE_LIMIT);
    }

    function it_should_return_setted_data_response_limit(ScopeConfigInterface $scopeConfig)
    {
        $scopeConfig->getValue(ConfigProvider::CUSTOMER_DATA_RESPONSE_LIMIT)->willReturn(365);

        $this->getCustomerDataResponseLimit()->shouldReturn(365);
    }
}
