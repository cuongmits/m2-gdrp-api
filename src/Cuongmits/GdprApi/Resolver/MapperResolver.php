<?php

namespace Cuongmits\GdprApi\Resolver;

use Cuongmits\GdprApi\Filter\RemoveNullValueItemFilter;
use Cuongmits\GdprApi\Mapper\CustomerRelatedGdprDataMapper;
use Cuongmits\GdprApi\Mapper\OrderRelatedGdprDataMapper;
use Cuongmits\GdprApi\Mapper\QuoteRelatedGdprDataMapper;
use Cuongmits\GdprApi\Model\CurrentIdSets;
use Cuongmits\GdprApi\Model\CustomerQocSet;
use Cuongmits\GdprApi\Provider\CustomerAccountStatusProvider;

class MapperResolver
{
    /** @var QuoteRelatedGdprDataMapper */
    private $quoteRelatedGdprDataMapper;

    /** @var OrderRelatedGdprDataMapper */
    private $orderRelatedGdprDataMapper;

    /** @var CustomerRelatedGdprDataMapper */
    private $customerRelatedGdprDataMapper;

    /** @var CustomerAccountStatusProvider */
    private $customerAccountStatusProvider;

    /** @var RemoveNullValueItemFilter */
    private $removeNullValueItemFilter;

    public function __construct(
        QuoteRelatedGdprDataMapper $quoteRelatedGdprDataMapper,
        OrderRelatedGdprDataMapper $orderRelatedGdprDataMapper,
        CustomerRelatedGdprDataMapper $customerRelatedGdprDataMapper,
        CustomerAccountStatusProvider $customerAccountStatusProvider,
        RemoveNullValueItemFilter $removeNullValueItemFilter
    ) {
        $this->quoteRelatedGdprDataMapper = $quoteRelatedGdprDataMapper;
        $this->orderRelatedGdprDataMapper = $orderRelatedGdprDataMapper;
        $this->customerRelatedGdprDataMapper = $customerRelatedGdprDataMapper;
        $this->customerAccountStatusProvider = $customerAccountStatusProvider;
        $this->removeNullValueItemFilter = $removeNullValueItemFilter;
    }

    public function initMappers(CurrentIdSets $currentIdSets): void
    {
        $this->quoteRelatedGdprDataMapper->load($currentIdSets->getQuoteIds());
        $this->orderRelatedGdprDataMapper->load($currentIdSets->getOrderIds());
        $this->customerRelatedGdprDataMapper->load($currentIdSets->getCustomerIds());
    }

    public function getDataOfCustomerQocSetFromMappers(CustomerQocSet $customerQocSet): array
    {
        $result = array_merge(
            $this->customerAccountStatusProvider->getAccountStatus($customerQocSet),
            $this->customerRelatedGdprDataMapper->map($customerQocSet->getCustomerId())
        );

        foreach ($customerQocSet->getQuoteOrderSets() as $quoteOrderSet) {
            $result = array_merge(
                $result,
                $this->orderRelatedGdprDataMapper->map($quoteOrderSet->getOrderId()),
                $this->quoteRelatedGdprDataMapper->map($quoteOrderSet->getQuoteId())
            );
        }

        return $this->removeNullValueItemFilter->apply($result);
    }
}
