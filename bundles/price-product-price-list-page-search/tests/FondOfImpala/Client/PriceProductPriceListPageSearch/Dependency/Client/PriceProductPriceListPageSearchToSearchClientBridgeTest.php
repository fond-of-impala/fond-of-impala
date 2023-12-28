<?php

namespace FondOfImpala\Client\PriceProductPriceListPageSearch\Dependency\Client;

use Codeception\Test\Unit;
use Elastica\ResultSet;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Client\Search\Dependency\Plugin\QueryExpanderPluginInterface;
use Spryker\Client\Search\Dependency\Plugin\QueryInterface;
use Spryker\Client\Search\SearchClientInterface;

class PriceProductPriceListPageSearchToSearchClientBridgeTest extends Unit
{
    protected PriceProductPriceListPageSearchToSearchClientBridge $bridge;

    protected MockObject|SearchClientInterface $searchClientMock;

    protected MockObject|QueryInterface $queryMock;

    protected MockObject|QueryExpanderPluginInterface $queryExpanderPluginMock;

    protected MockObject|ResultSet $resultSetMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->searchClientMock = $this->getMockBuilder(SearchClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->queryMock = $this->getMockBuilder(QueryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->queryExpanderPluginMock = $this->getMockBuilder(QueryExpanderPluginInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->resultSetMock = $this->getMockBuilder(ResultSet::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bridge = new PriceProductPriceListPageSearchToSearchClientBridge(
            $this->searchClientMock,
        );
    }

    /**
     * @return void
     */
    public function testSearch(): void
    {
        $this->searchClientMock->expects(static::atLeastOnce())
            ->method('search')
            ->with($this->queryMock, [], [])
            ->willReturn([$this->resultSetMock]);

        static::assertEquals(
            [$this->resultSetMock],
            $this->bridge->search($this->queryMock),
        );
    }

    /**
     * @return void
     */
    public function testExpandQuery(): void
    {
        $this->searchClientMock->expects(static::atLeastOnce())
            ->method('expandQuery')
            ->with($this->queryMock, [$this->queryExpanderPluginMock], [])
            ->willReturn($this->queryMock);

        static::assertEquals(
            $this->queryMock,
            $this->bridge->expandQuery($this->queryMock, [$this->queryExpanderPluginMock]),
        );
    }
}
