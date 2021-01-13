<?php

namespace Cuongmits\GdprApi\Resolver;

use Cuongmits\GdprApi\Model\GdprGetRequestData;

class CustomerQocSetsPaginationResolver
{
    /**
     * @param GdprGetRequestData $requestData
     * @param array $allUniqueCustomerQocSets
     *
     * @return array
     */
    public function getCustomerQocSetsByCursor(GdprGetRequestData $requestData, array $allUniqueCustomerQocSets): array
    {
        arsort($allUniqueCustomerQocSets);

        return array_slice($allUniqueCustomerQocSets, $requestData->getCursor(), $requestData->getLimit());
    }
}
