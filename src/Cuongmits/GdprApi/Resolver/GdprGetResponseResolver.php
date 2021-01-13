<?php

namespace Cuongmits\GdprApi\Resolver;

use Component\Functor\NotNullOrEmptyStringFilter;
use Cuongmits\GdprApi\Model\GdprGetRequestData;
use Cuongmits\GdprApi\Provider\GdprGetRequestResultsProvider;

class GdprGetResponseResolver
{
    /** @var GdprGetRequestResultsProvider */
    private $resultsItemForGetRequestProvider;

    public function __construct(GdprGetRequestResultsProvider $resultsItemForGetRequestProvider)
    {
        $this->resultsItemForGetRequestProvider = $resultsItemForGetRequestProvider;
    }

    public function getResponse(GdprGetRequestData $requestData, array $currentCustomerQocSets): array
    {
        $query = $this->getQuery($requestData);
        $current = $requestData->getCursor();
        $prev = $requestData->getCursor() - $requestData->getLimit();
        $next = $requestData->getCursor() + $requestData->getLimit();
        $size = count($currentCustomerQocSets);
        $limit = $requestData->getLimit();
        $results = $this->resultsItemForGetRequestProvider->get($currentCustomerQocSets);

        $res =  [
            'label' => 'Bestellungen',
            'description' => 'Kundendaten für C&R Bestellungen',
            'page' => [
                'cursor' => [
                    'prev' => $prev > 0 ? $prev : 0,
                    'current' => $current,
                    'next' => $next,
                ],
                'size' => $size,
                'limit' => $limit,
            ],
            'query' => $query,
            'results' => $results,
        ];

        return $res;
    }

    private function getQuery(GdprGetRequestData $requestData): array
    {
        return array_filter([
            'first_name' => $requestData->getFirstname(),
            'last_name' => $requestData->getLastname(),
            'email_address' => $requestData->getEmail(),
            'debitor_number' => $requestData->getSapDebitor(),
            'debitor_card_number' => $requestData->getLoyaltyCardNumber(),
            'cursor' => $requestData->getCursor(),
            'limit' => $requestData->getLimit()
        ], new NotNullOrEmptyStringFilter());
    }
}
