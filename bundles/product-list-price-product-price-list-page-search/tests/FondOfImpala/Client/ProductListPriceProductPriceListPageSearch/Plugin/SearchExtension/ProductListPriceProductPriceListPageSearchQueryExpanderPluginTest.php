<?php

namespace FondOfImpala\Client\ProductListPriceProductPriceListPageSearch\Plugin\SearchExtension;

use Codeception\Test\Unit;
use Elastica\Query;
use Elastica\Query\BoolQuery;
use Elastica\Query\Terms;
use FondOfImpala\Client\ProductListPriceProductPriceListPageSearch\Dependency\Client\ProductListPriceProductPriceListPageSearchToCustomerClientInterface;
use FondOfImpala\Client\ProductListPriceProductPriceListPageSearch\ProductListPriceProductPriceListPageSearchFactory;
use Generated\Shared\Transfer\CustomerProductListCollectionTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use InvalidArgumentException;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Client\Kernel\AbstractFactory;
use Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface;

class ProductListPriceProductPriceListPageSearchQueryExpanderPluginTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface
     */
    protected MockObject|QueryInterface $queryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Elastica\Query
     */
    protected MockObject|Query $elasticaQueryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Client\ProductListPriceProductPriceListPageSearch\ProductListPriceProductPriceListPageSearchFactory
     */
    protected MockObject|ProductListPriceProductPriceListPageSearchFactory $productListPriceProductPriceListPageSearchFactoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Client\ProductListPriceProductPriceListPageSearch\Dependency\Client\ProductListPriceProductPriceListPageSearchToCustomerClientInterface
     */
    protected MockObject|ProductListPriceProductPriceListPageSearchToCustomerClientInterface $customerClientMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CustomerTransfer
     */
    protected MockObject|CustomerTransfer $customerTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CustomerProductListCollectionTransfer
     */
    protected MockObject|CustomerProductListCollectionTransfer $customerProductListCollectionTransferMock;

    /**
     * @var array<int>
     */
    protected array $blacklistIds;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Elastica\Query\BoolQuery
     */
    protected MockObject|BoolQuery $boolQueryMock;

    /**
     * @var array<int>
     */
    protected array $whitelistIds;

    /**
     * @var \FondOfImpala\Client\ProductListPriceProductPriceListPageSearch\Plugin\SearchExtension\ProductListPriceProductPriceListPageSearchQueryExpanderPlugin
     */
    protected ProductListPriceProductPriceListPageSearchQueryExpanderPlugin $productListPriceProductPriceListPageSearchQueryExpanderPlugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->productListPriceProductPriceListPageSearchFactoryMock = $this->getMockBuilder(ProductListPriceProductPriceListPageSearchFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->queryMock = $this->getMockBuilder(QueryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->elasticaQueryMock = $this->getMockBuilder(Query::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerClientMock = $this->getMockBuilder(ProductListPriceProductPriceListPageSearchToCustomerClientInterface::class)
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

        $this->blacklistIds = [1];

        $this->whitelistIds = [2];

        $this->productListPriceProductPriceListPageSearchQueryExpanderPlugin = new class (
            $this->productListPriceProductPriceListPageSearchFactoryMock
        ) extends ProductListPriceProductPriceListPageSearchQueryExpanderPlugin {
            protected ProductListPriceProductPriceListPageSearchFactory $productListPriceProductPriceListPageSearchFactory;

            /**
             * @param \FondOfImpala\Client\ProductListPriceProductPriceListPageSearch\ProductListPriceProductPriceListPageSearchFactory $productListPriceProductPriceListPageSearchFactory
             */
            public function __construct(ProductListPriceProductPriceListPageSearchFactory $productListPriceProductPriceListPageSearchFactory)
            {
                $this->productListPriceProductPriceListPageSearchFactory = $productListPriceProductPriceListPageSearchFactory;
            }

            /**
             * @return \Spryker\Client\Kernel\AbstractFactory
             */
            public function getFactory(): AbstractFactory
            {
                return $this->productListPriceProductPriceListPageSearchFactory;
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
        $this->queryMock->expects(self::atLeastOnce())
            ->method('getSearchQuery')
            ->willReturn($this->elasticaQueryMock);

        $this->productListPriceProductPriceListPageSearchFactoryMock->expects(self::atLeastOnce())
            ->method('getCustomerClient')
            ->willReturn($this->customerClientMock);

        $this->customerClientMock->expects(self::atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock->expects(self::atLeastOnce())
            ->method('getCustomerProductListCollection')
            ->willReturn($this->customerProductListCollectionTransferMock);

        $this->customerProductListCollectionTransferMock->expects(self::atLeastOnce())
            ->method('getBlacklistIds')
            ->willReturn($this->blacklistIds);

        $this->elasticaQueryMock->expects(self::atLeastOnce())
            ->method('getQuery')
            ->willReturn($this->boolQueryMock);

        $this->boolQueryMock->expects(self::atLeastOnce())
            ->method('addMustNot')
            ->willReturnSelf();

        $this->customerProductListCollectionTransferMock->expects(self::atLeastOnce())
            ->method('getWhitelistIds')
            ->willReturn($this->whitelistIds);

        $this->boolQueryMock->expects(self::atLeastOnce())
            ->method('addFilter')
            ->willReturnSelf();

        self::assertEquals(
            $this->queryMock,
            $this->productListPriceProductPriceListPageSearchQueryExpanderPlugin->expandQuery(
                $this->queryMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testExpandQueryNoIds(): void
    {
        $this->queryMock->expects(self::atLeastOnce())
            ->method('getSearchQuery')
            ->willReturn($this->elasticaQueryMock);

        $this->productListPriceProductPriceListPageSearchFactoryMock->expects(self::atLeastOnce())
            ->method('getCustomerClient')
            ->willReturn($this->customerClientMock);

        $this->customerClientMock->expects(self::atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock->expects(self::atLeastOnce())
            ->method('getCustomerProductListCollection')
            ->willReturn($this->customerProductListCollectionTransferMock);

        $this->customerProductListCollectionTransferMock->expects(self::atLeastOnce())
            ->method('getBlacklistIds')
            ->willReturn([]);

        $this->customerProductListCollectionTransferMock->expects(self::atLeastOnce())
            ->method('getWhitelistIds')
            ->willReturn([]);

        self::assertEquals(
            $this->queryMock,
            $this->productListPriceProductPriceListPageSearchQueryExpanderPlugin->expandQuery(
                $this->queryMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testExpandQueryCustomerNull(): void
    {
        $this->queryMock->expects(self::atLeastOnce())
            ->method('getSearchQuery')
            ->willReturn($this->elasticaQueryMock);

        $this->productListPriceProductPriceListPageSearchFactoryMock->expects(self::atLeastOnce())
            ->method('getCustomerClient')
            ->willReturn($this->customerClientMock);

        $this->customerClientMock->expects(self::atLeastOnce())
            ->method('getCustomer')
            ->willReturn(null);

        self::assertEquals(
            $this->queryMock,
            $this->productListPriceProductPriceListPageSearchQueryExpanderPlugin->expandQuery(
                $this->queryMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testExpandQueryCustomerProductListCollectionNull(): void
    {
        $this->queryMock->expects(self::atLeastOnce())
            ->method('getSearchQuery')
            ->willReturn($this->elasticaQueryMock);

        $this->productListPriceProductPriceListPageSearchFactoryMock->expects(self::atLeastOnce())
            ->method('getCustomerClient')
            ->willReturn($this->customerClientMock);

        $this->customerClientMock->expects(self::atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock->expects(self::atLeastOnce())
            ->method('getCustomerProductListCollection')
            ->willReturn(null);

        self::assertEquals(
            $this->queryMock,
            $this->productListPriceProductPriceListPageSearchQueryExpanderPlugin->expandQuery(
                $this->queryMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testExpandQueryNoBoolQuery(): void
    {
        $this->queryMock->expects(self::atLeastOnce())
            ->method('getSearchQuery')
            ->willReturn($this->elasticaQueryMock);

        $this->productListPriceProductPriceListPageSearchFactoryMock->expects(self::atLeastOnce())
            ->method('getCustomerClient')
            ->willReturn($this->customerClientMock);

        $this->customerClientMock->expects(self::atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock->expects(self::atLeastOnce())
            ->method('getCustomerProductListCollection')
            ->willReturn($this->customerProductListCollectionTransferMock);

        $this->customerProductListCollectionTransferMock->expects(self::atLeastOnce())
            ->method('getBlacklistIds')
            ->willReturn($this->blacklistIds);

        $this->elasticaQueryMock->expects(self::atLeastOnce())
            ->method('getQuery')
            ->willReturn($this->queryMock);

        try {
            $this->productListPriceProductPriceListPageSearchQueryExpanderPlugin->expandQuery(
                $this->queryMock,
            );
            self::fail();
        } catch (InvalidArgumentException) {
        }
    }
}
