<?php

namespace Cuongmits\GdprApi\Provider;

use Cuongmits\GdprApi\Model\CustomerQocSet;

class CustomerAccountStatusProvider
{
    public function getAccountStatus(CustomerQocSet $customerQocSet): array
    {
        return [
            [
                'label' => __('Account'),
                'value' => is_null($customerQocSet->getCustomerId()) ? __('no') : __('yes')
            ]
        ];
    }
}
