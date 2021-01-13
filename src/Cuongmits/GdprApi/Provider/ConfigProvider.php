<?php

namespace Cuongmits\GdprApi\Provider;

use Magento\Framework\App\Config\ScopeConfigInterface;

class ConfigProvider
{
    public const DEFAULT_CUSTOMER_DATA_RESPONSE_LIMIT = 1000;
    public const CUSTOMER_DATA_RESPONSE_LIMIT = 'toom_general/customer_data_request/customer_data_response_limit';

    /** @var ScopeConfigInterface */
    private $scopeConfig;

    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    public function getCustomerDataResponseLimit(): int
    {
        $limit = $this->scopeConfig->getValue(self::CUSTOMER_DATA_RESPONSE_LIMIT);

        return $limit ?? self::DEFAULT_CUSTOMER_DATA_RESPONSE_LIMIT;
    }
}
