<?php

namespace Cuongmits\GdprApi\Provider\QocSet;

use Magento\Eav\Model\ResourceModel\Entity\Attribute;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Cuongmits\GdprApi\Model\GdprGetRequestData;
use Cuongmits\GdprApi\Provider\SetProviderInterface;

abstract class AbstractQocSetProvider implements SetProviderInterface
{
    /** @var BindDataProvider */
    private $bindDataProvider;

    /** @var Attribute */
    private $attributeResource;

    /** @var AdapterInterface */
    protected $connection;

    /** @var ConditionsProvider */
    protected $conditionsProvider;

    public function __construct(
        ResourceConnection $resourceConnection,
        Attribute $attributeResource,
        ConditionsProvider $conditionsProvider,
        BindDataProvider $bindDataProvider
    ) {
        $this->connection = $resourceConnection->getConnection();
        $this->attributeResource = $attributeResource;
        $this->conditionsProvider = $conditionsProvider;
        $this->bindDataProvider = $bindDataProvider;
    }

    public function get(GdprGetRequestData $requestData): array
    {
        $query = $this->getQuery($requestData);
        $bindData = $this->bindDataProvider->getBindData($requestData);
        $res = $this->connection->query($query, $bindData);

        return $res->fetchAll();
    }

    /**
     * NOTE: Currently we're using OR conditions to see how it impacts to the shop's performance
     *  In case big impact, then we need to change this to AND condition
     *
     * @param GdprGetRequestData $requestData
     *
     * @return string
     */
    abstract protected function getQuery(GdprGetRequestData $requestData): string;
}
