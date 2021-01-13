<?php

namespace Cuongmits\GdprApi\Validator;

use Cuongmits\GdprApi\Provider\ConfigProvider;

class UniqueCustomerLimitValidator
{
    /** @var ConfigProvider */
    private $configProvider;

    public function __construct(ConfigProvider $configProvider)
    {
        $this->configProvider = $configProvider;
    }

    public function isValid(array $uniqueCustomerSets): bool
    {
        if (count($uniqueCustomerSets) > $this->configProvider->getCustomerDataResponseLimit()) {
            return false;
        }

        return true;
    }
}
