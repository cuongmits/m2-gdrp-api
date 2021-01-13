<?php

namespace Cuongmits\GdprApi\Provider\QocSet;

use Component\Functor\NotEmptyFilter;
use Magento\Eav\Model\ResourceModel\Entity\Attribute;
use Cuongmits\CustomerAttribute;
use Cuongmits\GdprApi\Model\GdprGetRequestData;

class BindDataProvider
{
    /** @var Attribute */
    private $attributeResource;

    public function __construct(Attribute $attributeResource)
    {
        $this->attributeResource = $attributeResource;
    }

    public function getBindData(GdprGetRequestData $requestData): array
    {
        $sapDebitor = $requestData->getSapDebitor();
        $loyaltyCardNumber = $requestData->getLoyaltyCardNumber();

        $debitorAttrId = empty($sapDebitor) ? null
            : $this->attributeResource->getIdByCode('customer', CustomerAttribute::SAP_DEBITOR);
        $loyaltyAttrId = empty($loyaltyCardNumber) ? null
            : $this->attributeResource->getIdByCode('customer', CustomerAttribute::LOYALTY_CARD);

        $bindData = [
            'first_name' => $requestData->getFirstname(),
            'last_name' => $requestData->getLastname(),
            'email' => $requestData->getEmail(),
            'debitor_attr_id' => $debitorAttrId,
            'sap_debitor' => $sapDebitor,
            'loyalty_attr_id' => $loyaltyAttrId,
            'loyalty_card_number' => $loyaltyCardNumber
        ];

        return array_filter($bindData, new NotEmptyFilter());
    }
}
