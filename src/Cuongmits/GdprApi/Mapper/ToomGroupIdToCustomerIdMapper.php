<?php

namespace Cuongmits\GdprApi\Mapper;

class CuongmitsGroupIdToCustomerIdMapper
{
    /** @var array */
    private $mapData;

    public static function create(array $qocSets): self
    {
        $mapData = [];
        foreach ($qocSets as $qocSet) {
            if (!empty($qocSet['toom_group_id']) && !empty($qocSet['customer_id'])) {
                $mapData[$qocSet['toom_group_id']] = $qocSet['customer_id'];
            }
        }

        return new self($mapData);
    }

    private function __construct(array $mapData)
    {
        $this->mapData = $mapData;
    }

    public function map(?string $groupId): ?int
    {
        if (empty($groupId) || !isset($this->mapData[$groupId])) {
            return null;
        }

        return $this->mapData[$groupId];
    }
}
