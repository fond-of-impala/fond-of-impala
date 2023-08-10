<?php

namespace FondOfImpala\Client\PriceProductPriceListPageSearch;

use Codeception\Test\Unit;
use Elastica\ResultSet;
use FondOfImpala\Client\PriceProductPriceListPageSearch\Dependency\Client\PriceProductPriceListPageSearchToSearchClientInterface;
use Spryker\Glue\Kernel\Container;

class PriceProductPriceListPageSearchClientTest extends Unit
{
    /**
     * @var \FondOfImpala\Client\PriceProductPriceListPageSearch\PriceProductPriceListPageSearchClient
     */
    protected $priceProductPriceListPageSearchClient;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Client\PriceProductPriceListPageSearch\PriceProductPriceListPageSearchFactory
     */
    protected $priceProductPriceListPageSearchFactoryMock;

    /**
     * @var string
     */
    protected $search;

    /**
     * @var array
     */
    protected $requestParameters;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\Kernel\Container
     */
    protected $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Client\PriceProductPriceListPageSearch\Dependency\Client\PriceProductPriceListPageSearchToSearchClientInterface
     */
    protected $priceProductPriceListPageSearchToSearchClientInterfaceMock;

    /**
     * @var array
     */
    protected $resultSets;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Elastica\ResultSet
     */
    protected $resultSetMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->priceProductPriceListPageSearchFactoryMock = $this->getMockBuilder(PriceProductPriceListPageSearchFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceProductPriceListPageSearchToSearchClientInterfaceMock = $this->getMockBuilder(PriceProductPriceListPageSearchToSearchClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->resultSetMock = $this->getMockBuilder(ResultSet::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->search = 'search';

        $this->requestParameters = [

        ];

        $this->resultSets = [
            $this->resultSetMock,
        ];

        $this->priceProductPriceListPageSearchClient = new PriceProductPriceListPageSearchClient();
        $this->priceProductPriceListPageSearchClient->setFactory($this->priceProductPriceListPageSearchFactoryMock);
    }

    /**
     * @return void
     */
    public function testSearchAbstract(): void
    {
        $this->priceProductPriceListPageSearchFactoryMock->expects($this->atLeastOnce())
            ->method('getSearchClient')
            ->willReturn($this->priceProductPriceListPageSearchToSearchClientInterfaceMock);

        $this->priceProductPriceListPageSearchToSearchClientInterfaceMock->expects($this->atLeastOnce())
            ->method('search')
            ->willReturn($this->resultSets);

        $this->assertIsArray($this->priceProductPriceListPageSearchClient->searchAbstract($this->search, $this->requestParameters));
    }

    /**
     * @return void
     */
    public function testSearchAbstractCount(): void
    {
        $this->priceProductPriceListPageSearchFactoryMock->expects($this->atLeastOnce())
            ->method('getSearchClient')
            ->willReturn($this->priceProductPriceListPageSearchToSearchClientInterfaceMock);

        $this->priceProductPriceListPageSearchToSearchClientInterfaceMock->expects($this->atLeastOnce())
            ->method('search')
            ->willReturn($this->resultSetMock);

        $this->resultSetMock->expects($this->atLeastOnce())
            ->method('getTotalHits')
            ->willReturn(1);

        $this->assertSame(1, $this->priceProductPriceListPageSearchClient->searchAbstractCount($this->search, $this->requestParameters));
    }

    /**
     * @return void
     */
    public function testSearchConcrete(): void
    {
        $this->priceProductPriceListPageSearchFactoryMock->expects($this->atLeastOnce())
            ->method('getSearchClient')
            ->willReturn($this->priceProductPriceListPageSearchToSearchClientInterfaceMock);

        $this->priceProductPriceListPageSearchToSearchClientInterfaceMock->expects($this->atLeastOnce())
            ->method('search')
            ->willReturn($this->resultSets);

        $this->assertIsArray($this->priceProductPriceListPageSearchClient->searchConcrete($this->search, $this->requestParameters));
    }

    /**
     * @return void
     */
    public function testSearchConcreteCount(): void
    {
        $this->priceProductPriceListPageSearchFactoryMock->expects($this->atLeastOnce())
            ->method('getSearchClient')
            ->willReturn($this->priceProductPriceListPageSearchToSearchClientInterfaceMock);

        $this->priceProductPriceListPageSearchToSearchClientInterfaceMock->expects($this->atLeastOnce())
            ->method('search')
            ->willReturn($this->resultSetMock);

        $this->resultSetMock->expects($this->atLeastOnce())
            ->method('getTotalHits')
            ->willReturn(1);

        $this->assertSame(1, $this->priceProductPriceListPageSearchClient->searchConcreteCount($this->search, $this->requestParameters));
    }
}
