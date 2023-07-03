<?php

namespace FondOfImpala\Client\ProductListConditionalAvailabilityPageSearch\Plugin\SearchExtension;

use Codeception\Test\Unit;
use Elastica\Query as ElasticaQuery;
use Elastica\Query\BoolQuery;
use Elastica\Query\Terms;
use FondOfImpala\Client\ProductListConditionalAvailabilityPageSearch\Dependency\Client\ProductListConditionalAvailabilityPageSearchToCustomerClientInterface;
use FondOfImpala\Client\ProductListConditionalAvailabilityPageSearch\ProductListConditionalAvailabilityPageSearchFactory;
use Generated\Shared\Transfer\CustomerProductListCollectionTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use InvalidArgumentException;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Client\Kernel\AbstractFactory;
use Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface;

class ProductListConditionalAvailabilityPageSearchQueryExpanderPluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Client\ProductListConditionalAvailabilityPageSearch\Plugin\SearchExtension\ProductListConditionalAvailabilityPageSearchQueryExpanderPlugin
     */
    protected ProductListConditionalAvailabilityPageSearchQueryExpanderPlugin $plugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface
     */
    protected MockObject|QueryInterface $queryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Elastica\Query
     */
    protected MockObject|ElasticaQuery $elasticaQueryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Client\ProductListConditionalAvailabilityPageSearch\ProductListConditionalAvailabilityPageSearchFactory
     */
    protected MockObject|ProductListConditionalAvailabilityPageSearchFactory $factoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Client\ProductListConditionalAvailabilityPageSearch\Dependency\Client\ProductListConditionalAvailabilityPageSearchToCustomerClientInterface
     */
    protected MockObject|ProductListConditionalAvailabilityPageSearchToCustomerClientInterface $customerClientMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CustomerTransfer
     */
    protected $customerTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CustomerProductListCollectionTransfer
     */
    protected $customerProductListCollectionTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Elastica\Query\BoolQuery
     */
    protected $boolQueryMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->factoryMock = $this->getMockBuilder(ProductListConditionalAvailabilityPageSearchFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->queryMock = $this->getMockBuilder(QueryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->elasticaQueryMock = $this->getMockBuilder(ElasticaQuery::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerClientMock = $this->getMockBuilder(ProductListConditionalAvailabilityPageSearchToCustomerClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerTransferMock = $this->getMockBuilder(CustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerProductListCollectionTransferMock = $this->getMockBuilder(CustomerProductListCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->boolQueryMock = $this->getMockBuilder(BoolQuery::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new class (
            $this->factoryMock
        ) extends ProductListConditionalAvailabilityPageSearchQueryExpanderPlugin {
            protected ProductListConditionalAvailabilityPageSearchFactory $productListConditionalAvailabilityPageSearchFactory;

            /**
             * @param \FondOfImpala\Client\ProductListConditionalAvailabilityPageSearch\ProductListConditionalAvailabilityPageSearchFactory $productListConditionalAvailabilityPageSearchFactory
             */
            public function __construct(ProductListConditionalAvailabilityPageSearchFactory $productListConditionalAvailabilityPageSearchFactory)
            {
                $this->factory = $productListConditionalAvailabilityPageSearchFactory;
            }

            /**
             * @return \Spryker\Client\Kernel\AbstractFactory
             */
            protected function getFactory(): AbstractFactory
            {
                return $this->factory;
            }

            /**
             * @param array $blacklistIds
             *
             * @return \Elastica\Query\Terms
             */
            protected function createBlacklistTermQuery(array $blacklistIds): Terms
            {
                return new Terms('product-lists-black-lists', $blacklistIds);
            }

            /**
             * @param array $whitelistIds
             *
             * @return \Elastica\Query\Terms
             */
            protected function createWhitelistTermQuery(array $whitelistIds): Terms
            {
                return new Terms('product-lists-white-lists', $whitelistIds);
            }
        };
    }

    /**
     * @return void
     */
    public function testExpandQuery(): void
    {
        $blacklistIds = [1];
        $whitelistIds = [2];

        $this->queryMock->expects(static::atLeastOnce())
            ->method('getSearchQuery')
            ->willReturn($this->elasticaQueryMock);

        $this->factoryMock->expects(static::atLeastOnce())
            ->method('getCustomerClient')
            ->willReturn($this->customerClientMock);

        $this->customerClientMock->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getCustomerProductListCollection')
            ->willReturn($this->customerProductListCollectionTransferMock);

        $this->customerProductListCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getBlacklistIds')
            ->willReturn($blacklistIds);

        $this->elasticaQueryMock->expects(static::atLeastOnce())
            ->method('getQuery')
            ->willReturn($this->boolQueryMock);

        $this->boolQueryMock->expects(static::atLeastOnce())
            ->method('addMustNot')
            ->willReturnSelf();

        $this->customerProductListCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getWhitelistIds')
            ->willReturn($whitelistIds);

        $this->boolQueryMock->expects(static::atLeastOnce())
            ->method('addFilter')
            ->willReturnSelf();

        static::assertEquals($this->queryMock, $this->plugin->expandQuery($this->queryMock));
    }

    /**
     * @return void
     */
    public function testExpandQueryNoIds(): void
    {
        $this->queryMock->expects(static::atLeastOnce())
            ->method('getSearchQuery')
            ->willReturn($this->elasticaQueryMock);

        $this->factoryMock->expects(static::atLeastOnce())
            ->method('getCustomerClient')
            ->willReturn($this->customerClientMock);

        $this->customerClientMock->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getCustomerProductListCollection')
            ->willReturn($this->customerProductListCollectionTransferMock);

        $this->customerProductListCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getBlacklistIds')
            ->willReturn([]);

        $this->customerProductListCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getWhitelistIds')
            ->willReturn([]);

        static::assertEquals($this->queryMock, $this->plugin->expandQuery($this->queryMock));
    }

    /**
     * @return void
     */
    public function testExpandQueryCustomerNull(): void
    {
        $this->queryMock->expects(static::atLeastOnce())
            ->method('getSearchQuery')
            ->willReturn($this->elasticaQueryMock);

        $this->factoryMock->expects(static::atLeastOnce())
            ->method('getCustomerClient')
            ->willReturn($this->customerClientMock);

        $this->customerClientMock->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn(null);

        static::assertEquals($this->queryMock, $this->plugin->expandQuery($this->queryMock));
    }

    /**
     * @return void
     */
    public function testExpandQueryCustomerProductListCollectionNull(): void
    {
        $this->queryMock->expects(static::atLeastOnce())
            ->method('getSearchQuery')
            ->willReturn($this->elasticaQueryMock);

        $this->factoryMock->expects(static::atLeastOnce())
            ->method('getCustomerClient')
            ->willReturn($this->customerClientMock);

        $this->customerClientMock->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getCustomerProductListCollection')
            ->willReturn(null);

        static::assertEquals($this->queryMock, $this->plugin->expandQuery($this->queryMock));
    }

    /**
     * @return void
     */
    public function testExpandQueryNoBoolQuery(): void
    {
        $blacklistIds = [1];

        $this->queryMock->expects(static::atLeastOnce())
            ->method('getSearchQuery')
            ->willReturn($this->elasticaQueryMock);

        $this->factoryMock->expects(static::atLeastOnce())
            ->method('getCustomerClient')
            ->willReturn($this->customerClientMock);

        $this->customerClientMock->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock->expects(static::atLeastOnce())
            ->method('getCustomerProductListCollection')
            ->willReturn($this->customerProductListCollectionTransferMock);

        $this->customerProductListCollectionTransferMock->expects(static::atLeastOnce())
            ->method('getBlacklistIds')
            ->willReturn($blacklistIds);

        $this->elasticaQueryMock->expects(static::atLeastOnce())
            ->method('getQuery')
            ->willReturn($this->queryMock);

        try {
            $this->plugin->expandQuery($this->queryMock);
        } catch (InvalidArgumentException $exception) {
            static::assertInstanceOf(
                InvalidArgumentException::class,
                $exception,
            );
        }
    }
}
