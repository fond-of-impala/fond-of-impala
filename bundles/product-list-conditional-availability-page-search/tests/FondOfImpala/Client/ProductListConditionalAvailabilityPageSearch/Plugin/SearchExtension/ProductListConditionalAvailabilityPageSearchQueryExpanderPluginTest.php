<?php

namespace FondOfImpala\Client\ProductListConditionalAvailabilityPageSearch\Plugin\SearchExtension;

use Codeception\Test\Unit;
use Elastica\Query;
use Elastica\Query\BoolQuery;
use Elastica\Query\Terms;
use FondOfImpala\Client\ProductListConditionalAvailabilityPageSearch\Dependency\Client\ProductListConditionalAvailabilityPageSearchToCustomerClientInterface;
use FondOfImpala\Client\ProductListConditionalAvailabilityPageSearch\ProductListConditionalAvailabilityPageSearchFactory;
use Generated\Shared\Transfer\CustomerProductListCollectionTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use InvalidArgumentException;
use Spryker\Client\Kernel\AbstractFactory;
use Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface;

class ProductListConditionalAvailabilityPageSearchQueryExpanderPluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Client\ProductListConditionalAvailabilityPageSearch\Plugin\SearchExtension\ProductListConditionalAvailabilityPageSearchQueryExpanderPlugin
     */
    protected $productListConditionalAvailabilityPageSearchQueryExpanderPlugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface
     */
    protected $queryInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Elastica\Query
     */
    protected $queryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Client\ProductListConditionalAvailabilityPageSearch\ProductListConditionalAvailabilityPageSearchFactory
     */
    protected $productListConditionalAvailabilityPageSearchFactoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Client\ProductListConditionalAvailabilityPageSearch\Dependency\Client\ProductListConditionalAvailabilityPageSearchToCustomerClientInterface
     */
    protected $productListConditionalAvailabilityPageSearchToCustomerClientInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CustomerTransfer
     */
    protected $customerTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CustomerProductListCollectionTransfer
     */
    protected $customerProductListCollectionTransferMock;

    /**
     * @var array<int>
     */
    protected $blacklistIds;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Elastica\Query\BoolQuery
     */
    protected $boolQueryMock;

    /**
     * @var array<int>
     */
    protected $whitelistIds;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->productListConditionalAvailabilityPageSearchFactoryMock = $this->getMockBuilder(ProductListConditionalAvailabilityPageSearchFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->queryInterfaceMock = $this->getMockBuilder(QueryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->queryMock = $this->getMockBuilder(Query::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productListConditionalAvailabilityPageSearchToCustomerClientInterfaceMock = $this->getMockBuilder(ProductListConditionalAvailabilityPageSearchToCustomerClientInterface::class)
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

        $this->productListConditionalAvailabilityPageSearchQueryExpanderPlugin = new class (
            $this->productListConditionalAvailabilityPageSearchFactoryMock
        ) extends ProductListConditionalAvailabilityPageSearchQueryExpanderPlugin {
            protected ProductListConditionalAvailabilityPageSearchFactory $productListConditionalAvailabilityPageSearchFactory;

            /**
             * @param \FondOfImpala\Client\ProductListConditionalAvailabilityPageSearch\ProductListConditionalAvailabilityPageSearchFactory $productListConditionalAvailabilityPageSearchFactory
             */
            public function __construct(ProductListConditionalAvailabilityPageSearchFactory $productListConditionalAvailabilityPageSearchFactory)
            {
                $this->productListConditionalAvailabilityPageSearchFactory = $productListConditionalAvailabilityPageSearchFactory;
            }

            /**
             * @return \Spryker\Client\Kernel\AbstractFactory
             */
            protected function getFactory(): AbstractFactory
            {
                return $this->productListConditionalAvailabilityPageSearchFactory;
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
        $this->queryInterfaceMock->expects($this->atLeastOnce())
            ->method('getSearchQuery')
            ->willReturn($this->queryMock);

        $this->productListConditionalAvailabilityPageSearchFactoryMock->expects($this->atLeastOnce())
            ->method('getCustomerClient')
            ->willReturn($this->productListConditionalAvailabilityPageSearchToCustomerClientInterfaceMock);

        $this->productListConditionalAvailabilityPageSearchToCustomerClientInterfaceMock->expects($this->atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock->expects($this->atLeastOnce())
            ->method('getCustomerProductListCollection')
            ->willReturn($this->customerProductListCollectionTransferMock);

        $this->customerProductListCollectionTransferMock->expects($this->atLeastOnce())
            ->method('getBlacklistIds')
            ->willReturn($this->blacklistIds);

        $this->queryMock->expects($this->atLeastOnce())
            ->method('getQuery')
            ->willReturn($this->boolQueryMock);

        $this->boolQueryMock->expects($this->atLeastOnce())
            ->method('addMustNot')
            ->willReturnSelf();

        $this->customerProductListCollectionTransferMock->expects($this->atLeastOnce())
            ->method('getWhitelistIds')
            ->willReturn($this->whitelistIds);

        $this->boolQueryMock->expects($this->atLeastOnce())
            ->method('addFilter')
            ->willReturnSelf();

        $this->assertInstanceOf(
            QueryInterface::class,
            $this->productListConditionalAvailabilityPageSearchQueryExpanderPlugin->expandQuery(
                $this->queryInterfaceMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testExpandQueryNoIds(): void
    {
        $this->queryInterfaceMock->expects($this->atLeastOnce())
            ->method('getSearchQuery')
            ->willReturn($this->queryMock);

        $this->productListConditionalAvailabilityPageSearchFactoryMock->expects($this->atLeastOnce())
            ->method('getCustomerClient')
            ->willReturn($this->productListConditionalAvailabilityPageSearchToCustomerClientInterfaceMock);

        $this->productListConditionalAvailabilityPageSearchToCustomerClientInterfaceMock->expects($this->atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock->expects($this->atLeastOnce())
            ->method('getCustomerProductListCollection')
            ->willReturn($this->customerProductListCollectionTransferMock);

        $this->customerProductListCollectionTransferMock->expects($this->atLeastOnce())
            ->method('getBlacklistIds')
            ->willReturn([]);

        $this->customerProductListCollectionTransferMock->expects($this->atLeastOnce())
            ->method('getWhitelistIds')
            ->willReturn([]);

        $this->assertInstanceOf(
            QueryInterface::class,
            $this->productListConditionalAvailabilityPageSearchQueryExpanderPlugin->expandQuery(
                $this->queryInterfaceMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testExpandQueryCustomerNull(): void
    {
        $this->queryInterfaceMock->expects($this->atLeastOnce())
            ->method('getSearchQuery')
            ->willReturn($this->queryMock);

        $this->productListConditionalAvailabilityPageSearchFactoryMock->expects($this->atLeastOnce())
            ->method('getCustomerClient')
            ->willReturn($this->productListConditionalAvailabilityPageSearchToCustomerClientInterfaceMock);

        $this->productListConditionalAvailabilityPageSearchToCustomerClientInterfaceMock->expects($this->atLeastOnce())
            ->method('getCustomer')
            ->willReturn(null);

        $this->assertInstanceOf(
            QueryInterface::class,
            $this->productListConditionalAvailabilityPageSearchQueryExpanderPlugin->expandQuery(
                $this->queryInterfaceMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testExpandQueryCustomerProductListCollectionNull(): void
    {
        $this->queryInterfaceMock->expects($this->atLeastOnce())
            ->method('getSearchQuery')
            ->willReturn($this->queryMock);

        $this->productListConditionalAvailabilityPageSearchFactoryMock->expects($this->atLeastOnce())
            ->method('getCustomerClient')
            ->willReturn($this->productListConditionalAvailabilityPageSearchToCustomerClientInterfaceMock);

        $this->productListConditionalAvailabilityPageSearchToCustomerClientInterfaceMock->expects($this->atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock->expects($this->atLeastOnce())
            ->method('getCustomerProductListCollection')
            ->willReturn(null);

        $this->assertInstanceOf(
            QueryInterface::class,
            $this->productListConditionalAvailabilityPageSearchQueryExpanderPlugin->expandQuery(
                $this->queryInterfaceMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testExpandQueryNoBoolQuery(): void
    {
        $this->queryInterfaceMock->expects($this->atLeastOnce())
            ->method('getSearchQuery')
            ->willReturn($this->queryMock);

        $this->productListConditionalAvailabilityPageSearchFactoryMock->expects($this->atLeastOnce())
            ->method('getCustomerClient')
            ->willReturn($this->productListConditionalAvailabilityPageSearchToCustomerClientInterfaceMock);

        $this->productListConditionalAvailabilityPageSearchToCustomerClientInterfaceMock->expects($this->atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->customerTransferMock);

        $this->customerTransferMock->expects($this->atLeastOnce())
            ->method('getCustomerProductListCollection')
            ->willReturn($this->customerProductListCollectionTransferMock);

        $this->customerProductListCollectionTransferMock->expects($this->atLeastOnce())
            ->method('getBlacklistIds')
            ->willReturn($this->blacklistIds);

        $this->queryMock->expects($this->atLeastOnce())
            ->method('getQuery')
            ->willReturn($this->queryInterfaceMock);

        try {
            $this->productListConditionalAvailabilityPageSearchQueryExpanderPlugin->expandQuery(
                $this->queryInterfaceMock,
            );
        } catch (InvalidArgumentException $exception) {
            $this->assertInstanceOf(
                InvalidArgumentException::class,
                $exception,
            );
        }
    }
}
