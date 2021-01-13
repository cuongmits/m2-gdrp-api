<?php

namespace Cuongmits\GdprApi\Provider;

use Cuongmits\GdprApi\Model\CustomerQocSet;
use Cuongmits\GdprApi\Resolver\CurrentIdSetsResolver;
use Cuongmits\GdprApi\Resolver\MapperResolver;

class GdprGetRequestResultsProvider
{
    /** @var CurrentIdSetsResolver */
    private $currentIdsResolver;

    /** @var MapperResolver */
    private $mapperResolver;

    public function __construct(
        CurrentIdSetsResolver $currentIdsResolver,
        MapperResolver $mapperResolver
    ) {
        $this->currentIdsResolver = $currentIdsResolver;
        $this->mapperResolver = $mapperResolver;
    }

    /**
     * @param CustomerQocSet[] $currentCustomerQocSets
     *
     * @return array
     */
    public function get(array $currentCustomerQocSets): array
    {
        $currentIdSets = $this->currentIdsResolver->getCurrentIdSets($currentCustomerQocSets);
        $this->mapperResolver->initMappers($currentIdSets);

        $results = [];
        foreach ($currentCustomerQocSets as $customerQocSet) {
            $results[] = [
                'data' => $this->mapperResolver->getDataOfCustomerQocSetFromMappers($customerQocSet),
                'query_results' => [
                    'first_name' => 'Benjamin',
                    'last_name' => 'Amling',
                    'email_address' => 'b.amling@tarent.de',
                    'debitor_number' => '12345',
                    'debitor_card_number' => '67890',
                ],
                'delete_endpoints' => [],
                'anonymize_endpoints' => [],
            ];
        }

        return $results;
    }
}
