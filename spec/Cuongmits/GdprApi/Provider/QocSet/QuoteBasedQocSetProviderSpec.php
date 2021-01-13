<?php

namespace spec\Cuongmits\GdprApi\Provider\QocSet;

use Magento\Framework\App\ResourceConnection;
use PhpSpec\ObjectBehavior;
use Cuongmits\GdprApi\Model\GdprGetRequestData;
use Cuongmits\GdprApi\Provider\CustomerSetProvider;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Cuongmits\GdprApi\Provider\QocSet\AbstractQocSetProvider;
use Cuongmits\GdprApi\Provider\QocSet\BindDataProvider;
use Cuongmits\GdprApi\Provider\QocSet\ConditionsProvider;
use Cuongmits\GdprApi\Provider\QocSet\QuoteBasedQocSetProvider;
use Cuongmits\GdprApi\Provider\SetProviderInterface;
use Zend_Db_Statement_Interface;
use Prophecy\Argument;
use Magento\Eav\Model\ResourceModel\Entity\Attribute;

class QuoteBasedQocSetProviderSpec extends ObjectBehavior
{
    function let(
        ResourceConnection $resourceConnection,
        AdapterInterface $connection,
        Attribute $attributeResource,
        ConditionsProvider $conditionsProvider,
        BindDataProvider $bindDataProvider
    ) {
        $resourceConnection->getConnection()->willReturn($connection);
        $connection->getTableName(Argument::any())->willReturn('tablename');

        $this->beConstructedWith($resourceConnection, $attributeResource, $conditionsProvider, $bindDataProvider);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(QuoteBasedQocSetProvider::class);
    }

    function it_extends_abstract_class()
    {
        $this->shouldImplement(AbstractQocSetProvider::class);
    }

    function it_implements_interface()
    {
        $this->shouldImplement(SetProviderInterface::class);
    }

    function it_should_return_correct_customer_set(
        AdapterInterface $connection,
        Zend_Db_Statement_Interface $res,
        BindDataProvider $bindDataProvider,
        GdprGetRequestData $requestData
    ) {
        $bindDataProvider->getBindData($requestData)->willReturn(['bind data']);

        $connection->query(Argument::any(), ['bind data'])->willReturn($res);

        $customerSets = [
            ['quote order customer set 1'],
            ['quote order customer set 2'],
        ];
        $res->fetchAll()->willReturn($customerSets);

        $this->get($requestData)->shouldReturn($customerSets);
    }
}
