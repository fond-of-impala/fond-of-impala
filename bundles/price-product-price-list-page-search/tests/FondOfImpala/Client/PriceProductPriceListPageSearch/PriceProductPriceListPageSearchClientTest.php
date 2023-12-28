<?php

namespace FondOfImpala\Client\PriceProductPriceListPageSearch;

use Codeception\Test\Unit;
use Elastica\ResultSet;
use FondOfImpala\Client\PriceProductPriceListPageSearch\Dependency\Client\PriceProductPriceListPageSearchToSearchClientInterface;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Glue\Kernel\Container;

class PriceProductPriceListPageSearchClientTest extends Unit
{
    protected PriceProductPriceListPageSearchClient $priceProductPriceListPageSearchClient;

    protected MockObject|PriceProductPriceListPageSearchFactory $priceProductPriceListPageSearchFactoryMock;

    protected string $search;

    protected array $requestParameters;

    protected MockObject|Container $containerMock;

    protected MockObject|PriceProductPriceListPageSearchToSearchClientInterface $priceProductPriceListPageSearchToSearchClientInterfaceMock;

    /**
     * @var array<\Elastica\ResultSet|\PHPUnit\Framework\MockObject\MockObject>
     */
    protected array $resultSets;

    protected MockObject|ResultSet $resultSetMock;

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

        $this->requestParameters = [];

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
        $this->priceProductPriceListPageSearchFactoryMock->expects(static::atLeastOnce())
            ->method('getSearchClient')
            ->willReturn($this->priceProductPriceListPageSearchToSearchClientInterfaceMock);

        $this->priceProductPriceListPageSearchToSearchClientInterfaceMock->expects(static::atLeastOnce())
            ->method('search')
            ->willReturn($this->resultSets);

        static::assertEquals(
            $this->resultSets,
            $this->priceProductPriceListPageSearchClient->searchAbstract($this->search, $this->requestParameters),
        );
    }

    /**
     * @return void
     */
    public function testSearchAbstractCount(): void
    {
        $this->priceProductPriceListPageSearchFactoryMock->expects(static::atLeastOnce())
            ->method('getSearchClient')
            ->willReturn($this->priceProductPriceListPageSearchToSearchClientInterfaceMock);

        $this->priceProductPriceListPageSearchToSearchClientInterfaceMock->expects(static::atLeastOnce())
            ->method('search')
            ->willReturn($this->resultSetMock);

        $this->resultSetMock->expects(static::atLeastOnce())
            ->method('getTotalHits')
            ->willReturn(1);

        static::assertEquals(
            1,
            $this->priceProductPriceListPageSearchClient->searchAbstractCount($this->search, $this->requestParameters),
        );
    }

    /**
     * @return void
     */
    public function testSearchConcrete(): void
    {
        $this->priceProductPriceListPageSearchFactoryMock->expects(static::atLeastOnce())
            ->method('getSearchClient')
            ->willReturn($this->priceProductPriceListPageSearchToSearchClientInterfaceMock);

        $this->priceProductPriceListPageSearchToSearchClientInterfaceMock->expects(static::atLeastOnce())
            ->method('search')
            ->willReturn($this->resultSets);

        static::assertEquals(
            $this->resultSets,
            $this->priceProductPriceListPageSearchClient->searchConcrete($this->search, $this->requestParameters),
        );
    }

    /**
     * @return void
     */
    public function testSearchConcreteCount(): void
    {
        $this->priceProductPriceListPageSearchFactoryMock->expects(static::atLeastOnce())
            ->method('getSearchClient')
            ->willReturn($this->priceProductPriceListPageSearchToSearchClientInterfaceMock);

        $this->priceProductPriceListPageSearchToSearchClientInterfaceMock->expects(static::atLeastOnce())
            ->method('search')
            ->willReturn($this->resultSetMock);

        $this->resultSetMock->expects(static::atLeastOnce())
            ->method('getTotalHits')
            ->willReturn(1);

        static::assertEquals(
            1,
            $this->priceProductPriceListPageSearchClient->searchConcreteCount($this->search, $this->requestParameters),
        );
    }
}
