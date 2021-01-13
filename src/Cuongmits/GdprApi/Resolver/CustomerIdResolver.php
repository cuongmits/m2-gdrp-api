<?php

namespace Cuongmits\GdprApi\Resolver;

use Cuongmits\GdprApi\Mapper\CuongmitsGroupIdToCustomerIdMapper;

class CustomerIdResolver
{
    /** @var CuongmitsGroupIdToCustomerIdMapper */
    private $toomGroupIdToCustomerIdMapper;

    public function setCustomerIdForQocSets(array $qocSets): array
    {
        $this->toomGroupIdToCustomerIdMapper = CuongmitsGroupIdToCustomerIdMapper::create($qocSets);

        foreach ($qocSets as $key => $qocSet) {
            $qocSets[$key] = $this->setCustomerIdForQocSet($qocSet);
        }

        return $qocSets;
    }

    private function setCustomerIdForQocSet(array $qocSet): array
    {
        if (empty($qocSet['customer_id'])) {
            $qocSet['customer_id'] = $this->getExistingCustomerId($qocSet);
        }

        return $qocSet;
    }

    private function getExistingCustomerId(array $qocSet): ?int
    {
        if (!empty($qocSet['quote_customer_id'])) {
            return $qocSet['quote_customer_id'];
        }

        return $this->toomGroupIdToCustomerIdMapper->map($qocSet['toom_group_id']);
    }
}
