<?php

namespace FondOfImpala\Client\PriceProductPriceListPageSearch;

use Codeception\Test\Unit;
use FondOfImpala\Client\PriceProductPriceListPageSearch\Dependency\Client\PriceProductPriceListPageSearchToSearchClientInterface;
use FondOfImpala\Client\PriceProductPriceListPageSearch\Plugin\SearchExtension\PriceProductConcretePriceListSearchQueryPlugin;
use Spryker\Client\Kernel\Container;
use Spryker\Client\Search\Dependency\Plugin\QueryInterface;

class PriceProductPriceListPageSearchFactoryTest extends Unit
{
    /**
     * @var \FondOfImpala\Client\PriceProductPriceListPageSearch\PriceProductPriceListPageSearchFactory
     */
    protected $priceProductPriceListPageSearchFactory;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\Kernel\Container
     */
    protected $containerMock;

    /**
     * @var array
     */
    protected $requestParameters;

    /**
     * @var string
     */
    protected $search;

    /**
     * @var array
     */
    protected $queryExpanderPlugins;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\Search\Dependency\Plugin\SearchStringSetterInterface
     */
    protected $searchStringSetterInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Client\PriceProductPriceListPageSearch\Plugin\SearchExtension\PriceProductConcretePriceListSearchQueryPlugin
     */
    protected $priceProductConcretePriceListSearchQueryPluginMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Client\PriceProductPriceListPageSearch\Dependency\Client\PriceProductPriceListPageSearchToSearchClientInterface
     */
    private $priceProductPriceListPageSearchToSearchClientInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Client\PriceProductPriceListPageSearch\PriceProductPriceListPageSearchConfig
     */
    protected $priceProductPriceListPageSearchConfigMock;

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

        $this->priceProductPriceListPageSearchToSearchClientInterfaceMock = $this->getMockBuilder(PriceProductPriceListPageSearchToSearchClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceProductPriceListPageSearchConfigMock = $this->getMockBuilder(PriceProductPriceListPageSearchConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->search = 'search';

        $this->requestParameters = [

        ];

        $this->queryExpanderPlugins = [

        ];

        $this->priceProductPriceListPageSearchFactory = new PriceProductPriceListPageSearchFactory();
        $this->priceProductPriceListPageSearchFactory->setContainer($this->containerMock);
        $this->priceProductPriceListPageSearchFactory->setConfig($this->priceProductPriceListPageSearchConfigMock);
    }

    /**
     * @return void
     */
    public function testGetSearchClient(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->willReturn($this->priceProductPriceListPageSearchToSearchClientInterfaceMock);

        $this->assertInstanceOf(PriceProductPriceListPageSearchToSearchClientInterface::class, $this->priceProductPriceListPageSearchFactory->getSearchClient());
    }

    /**
     * @return void
     */
    public function testCreatePriceProductAbstractPriceListSearchQuery(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->withConsecutive(
                [PriceProductPriceListPageSearchDependencyProvider::PLUGIN_PRICE_PRODUCT_ABSTRACT_PRICE_LIST_SEARCH_QUERY],
                [PriceProductPriceListPageSearchDependencyProvider::CLIENT_SEARCH],
            )
            ->willReturnOnConsecutiveCalls(
                true,
                true,
            );

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->withConsecutive(
                [PriceProductPriceListPageSearchDependencyProvider::PLUGIN_PRICE_PRODUCT_ABSTRACT_PRICE_LIST_SEARCH_QUERY],
                [PriceProductPriceListPageSearchDependencyProvider::CLIENT_SEARCH],
            )
            ->willReturnOnConsecutiveCalls(
                $this->priceProductConcretePriceListSearchQueryPluginMock,
                $this->priceProductPriceListPageSearchToSearchClientInterfaceMock,
            );

        $this->assertInstanceOf(QueryInterface::class, $this->priceProductPriceListPageSearchFactory->createPriceProductAbstractPriceListSearchQuery($this->search, $this->requestParameters, $this->queryExpanderPlugins));
    }

    /**
     * @return void
     */
    public function testCreatePriceProductConcretePriceListSearchQuery(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->withConsecutive(
                [PriceProductPriceListPageSearchDependencyProvider::PLUGIN_PRICE_PRODUCT_CONCRETE_PRICE_LIST_SEARCH_QUERY],
                [PriceProductPriceListPageSearchDependencyProvider::CLIENT_SEARCH],
            )
            ->willReturnOnConsecutiveCalls(
                true,
                true,
            );

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->withConsecutive(
                [PriceProductPriceListPageSearchDependencyProvider::PLUGIN_PRICE_PRODUCT_CONCRETE_PRICE_LIST_SEARCH_QUERY],
                [PriceProductPriceListPageSearchDependencyProvider::CLIENT_SEARCH],
            )
            ->willReturnOnConsecutiveCalls(
                $this->priceProductConcretePriceListSearchQueryPluginMock,
                $this->priceProductPriceListPageSearchToSearchClientInterfaceMock,
            );

        $this->assertInstanceOf(QueryInterface::class, $this->priceProductPriceListPageSearchFactory->createPriceProductConcretePriceListSearchQuery($this->search, $this->requestParameters, $this->queryExpanderPlugins));
    }

    /**
     * @return void
     */
    public function testGetPriceProductAbstractPriceListSearchQueryExpanderPlugins(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->willReturn($this->queryExpanderPlugins);

        $this->assertIsArray($this->priceProductPriceListPageSearchFactory->getPriceProductAbstractPriceListSearchQueryExpanderPlugins());
    }

    /**
     * @return void
     */
    public function testGetPriceProductAbstractPriceListSearchCountQueryExpanderPlugins(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->willReturn([1]);

        $this->assertSame([1], $this->priceProductPriceListPageSearchFactory->getPriceProductAbstractPriceListSearchCountQueryExpanderPlugins());
    }

    /**
     * @return void
     */
    public function testGetPriceProductAbstractPriceListSearchResultFormatters(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->willReturn([]);

        $this->assertIsArray($this->priceProductPriceListPageSearchFactory->getPriceProductAbstractPriceListSearchResultFormatters());
    }

    /**
     * @return void
     */
    public function testGetPriceProductAbstractPriceListSearchQueryPlugin(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->willReturn($this->priceProductConcretePriceListSearchQueryPluginMock);

        $this->assertInstanceOf(QueryInterface::class, $this->priceProductPriceListPageSearchFactory->getPriceProductAbstractPriceListSearchQueryPlugin());
    }

    /**
     * @return void
     */
    public function testGetPriceProductConcretePriceListSearchQueryExpanderPlugins(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->willReturn([]);

        $this->assertIsArray($this->priceProductPriceListPageSearchFactory->getPriceProductConcretePriceListSearchQueryExpanderPlugins());
    }

    /**
     * @return void
     */
    public function testGetPriceProductConcretePriceListSearchCountQueryExpanderPlugins(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->willReturn([]);

        $this->assertIsArray($this->priceProductPriceListPageSearchFactory->getPriceProductConcretePriceListSearchCountQueryExpanderPlugins());
    }

    /**
     * @return void
     */
    public function testGetPriceProductConcretePriceListSearchResultFormatters(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->willReturn([]);

        $this->assertIsArray($this->priceProductPriceListPageSearchFactory->getPriceProductConcretePriceListSearchResultFormatters());
    }
}
