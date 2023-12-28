<?php

namespace FondOfImpala\Client\PriceProductPriceListPageSearch;

use Codeception\Test\Unit;
use FondOfImpala\Client\PriceProductPriceListPageSearch\Dependency\Client\PriceProductPriceListPageSearchToSearchClientBridge;
use FondOfImpala\Client\PriceProductPriceListPageSearch\Plugin\SearchExtension\PriceProductConcretePriceListSearchQueryPlugin;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Client\Kernel\Container;
use Spryker\Client\Search\Dependency\Plugin\QueryInterface;

class PriceProductPriceListPageSearchFactoryTest extends Unit
{
    protected MockObject|Container $containerMock;

    /**
     * @var array<\Spryker\Client\SearchExtension\Dependency\Plugin\QueryExpanderPluginInterface|\PHPUnit\Framework\MockObject\MockObject>
     */
    protected array $queryExpanderPluginMocks;

    protected MockObject|PriceProductConcretePriceListSearchQueryPlugin $priceProductConcretePriceListSearchQueryPluginMock;

    private MockObject|PriceProductPriceListPageSearchToSearchClientBridge $searchClientMock;

    protected MockObject|PriceProductPriceListPageSearchConfig $configMock;

    protected PriceProductPriceListPageSearchFactory $factory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceProductConcretePriceListSearchQueryPluginMock = $this->getMockBuilder(PriceProductConcretePriceListSearchQueryPlugin::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->searchClientMock = $this->getMockBuilder(PriceProductPriceListPageSearchToSearchClientBridge::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->queryExpanderPluginMocks = [];

        $this->factory = new PriceProductPriceListPageSearchFactory();
        $this->factory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testGetSearchClient(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->willReturn($this->searchClientMock);

        static::assertInstanceOf(
            PriceProductPriceListPageSearchToSearchClientBridge::class,
            $this->factory->getSearchClient(),
        );
    }

    /**
     * @return void
     */
    public function testCreatePriceProductAbstractPriceListSearchQuery(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->withConsecutive(
                [PriceProductPriceListPageSearchDependencyProvider::PLUGIN_PRICE_PRODUCT_ABSTRACT_PRICE_LIST_SEARCH_QUERY],
                [PriceProductPriceListPageSearchDependencyProvider::CLIENT_SEARCH],
            )
            ->willReturnOnConsecutiveCalls(
                true,
                true,
            );

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->withConsecutive(
                [PriceProductPriceListPageSearchDependencyProvider::PLUGIN_PRICE_PRODUCT_ABSTRACT_PRICE_LIST_SEARCH_QUERY],
                [PriceProductPriceListPageSearchDependencyProvider::CLIENT_SEARCH],
            )
            ->willReturnOnConsecutiveCalls(
                $this->priceProductConcretePriceListSearchQueryPluginMock,
                $this->searchClientMock,
            );

        static::assertInstanceOf(
            QueryInterface::class,
            $this->factory->createPriceProductAbstractPriceListSearchQuery(
                'foo',
                [],
                $this->queryExpanderPluginMocks,
            ),
        );
    }

    /**
     * @return void
     */
    public function testCreatePriceProductConcretePriceListSearchQuery(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->withConsecutive(
                [PriceProductPriceListPageSearchDependencyProvider::PLUGIN_PRICE_PRODUCT_CONCRETE_PRICE_LIST_SEARCH_QUERY],
                [PriceProductPriceListPageSearchDependencyProvider::CLIENT_SEARCH],
            )
            ->willReturnOnConsecutiveCalls(
                true,
                true,
            );

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->withConsecutive(
                [PriceProductPriceListPageSearchDependencyProvider::PLUGIN_PRICE_PRODUCT_CONCRETE_PRICE_LIST_SEARCH_QUERY],
                [PriceProductPriceListPageSearchDependencyProvider::CLIENT_SEARCH],
            )
            ->willReturnOnConsecutiveCalls(
                $this->priceProductConcretePriceListSearchQueryPluginMock,
                $this->searchClientMock,
            );

        static::assertInstanceOf(
            QueryInterface::class,
            $this->factory->createPriceProductConcretePriceListSearchQuery(
                'foo',
                [],
                $this->queryExpanderPluginMocks,
            ),
        );
    }

    /**
     * @return void
     */
    public function testGetPriceProductAbstractPriceListSearchQueryExpanderPlugins(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->willReturn($this->queryExpanderPluginMocks);

        static::assertEquals(
            $this->queryExpanderPluginMocks,
            $this->factory->getPriceProductAbstractPriceListSearchQueryExpanderPlugins(),
        );
    }

    /**
     * @return void
     */
    public function testGetPriceProductAbstractPriceListSearchCountQueryExpanderPlugins(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->willReturn([1]);

        static::assertSame([1], $this->factory->getPriceProductAbstractPriceListSearchCountQueryExpanderPlugins());
    }

    /**
     * @return void
     */
    public function testGetPriceProductAbstractPriceListSearchResultFormatters(): void
    {
        $priceProductAbstractPriceListSearchResultFormatters = [];

        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->willReturn($priceProductAbstractPriceListSearchResultFormatters);

        static::assertEquals(
            $priceProductAbstractPriceListSearchResultFormatters,
            $this->factory->getPriceProductAbstractPriceListSearchResultFormatters(),
        );
    }

    /**
     * @return void
     */
    public function testGetPriceProductAbstractPriceListSearchQueryPlugin(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->willReturn($this->priceProductConcretePriceListSearchQueryPluginMock);

        static::assertInstanceOf(QueryInterface::class, $this->factory->getPriceProductAbstractPriceListSearchQueryPlugin());
    }

    /**
     * @return void
     */
    public function testGetPriceProductConcretePriceListSearchQueryExpanderPlugins(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->willReturn($this->queryExpanderPluginMocks);

        static::assertEquals(
            $this->queryExpanderPluginMocks,
            $this->factory->getPriceProductConcretePriceListSearchQueryExpanderPlugins(),
        );
    }

    /**
     * @return void
     */
    public function testGetPriceProductConcretePriceListSearchCountQueryExpanderPlugins(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->willReturn($this->queryExpanderPluginMocks);

        static::assertEquals(
            $this->queryExpanderPluginMocks,
            $this->factory->getPriceProductConcretePriceListSearchCountQueryExpanderPlugins(),
        );
    }

    /**
     * @return void
     */
    public function testGetPriceProductConcretePriceListSearchResultFormatters(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->willReturn([]);

        static::assertIsArray($this->factory->getPriceProductConcretePriceListSearchResultFormatters());
    }
}
