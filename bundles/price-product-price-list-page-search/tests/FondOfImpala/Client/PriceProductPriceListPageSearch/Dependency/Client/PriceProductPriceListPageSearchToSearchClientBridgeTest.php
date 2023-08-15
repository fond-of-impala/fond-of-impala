<?php

namespace FondOfImpala\Client\PriceProductPriceListPageSearch\Dependency\Client;

use PHPUnit\Framework\MockObject\MockObject;
use Codeception\Test\Unit;
use Elastica\ResultSet;
use Spryker\Client\Search\Dependency\Plugin\QueryExpanderPluginInterface;
use Spryker\Client\Search\Dependency\Plugin\QueryInterface;
use Spryker\Client\Search\SearchClientInterface;

class PriceProductPriceListPageSearchToSearchClientBridgeTest extends Unit
{
    /**
     * @var \FondOfImpala\Client\PriceProductPriceListPageSearch\Dependency\Client\PriceProductPriceListPageSearchToSearchClientBridge
     */
    protected $priceProductPriceListPageSearchToSearchClientBridge;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\Search\SearchClientInterface
     */
    protected $searchClientInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\Search\Dependency\Plugin\QueryInterface
     */
    protected $queryInterfaceMock;

    private ?array $searchQueryExpanders = null;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\Search\Dependency\Plugin\QueryExpanderPluginInterface
     */
    protected $queryExpanderPluginInterfaceMock;

    private ?array $resultSets = null;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Elastica\ResultSet
     */
    private MockObject|ResultSet $resultSetMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->searchClientInterfaceMock = $this->getMockBuilder(SearchClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->queryInterfaceMock = $this->getMockBuilder(QueryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->queryExpanderPluginInterfaceMock = $this->getMockBuilder(QueryExpanderPluginInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->resultSetMock = $this->getMockBuilder(ResultSet::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->searchQueryExpanders = [
            $this->queryExpanderPluginInterfaceMock,
        ];

        $this->resultSets = [
            $this->resultSetMock,
        ];

        $this->priceProductPriceListPageSearchToSearchClientBridge = new PriceProductPriceListPageSearchToSearchClientBridge($this->searchClientInterfaceMock);
    }

    /**
     * @return void
     */
    public function testSearch(): void
    {
        $this->searchClientInterfaceMock->expects($this->atLeastOnce())
            ->method('search')
            ->willReturn($this->resultSets);

        $this->assertIsArray($this->priceProductPriceListPageSearchToSearchClientBridge->search($this->queryInterfaceMock, $this->searchQueryExpanders));
    }

    /**
     * @return void
     */
    public function testExpandQuery(): void
    {
        $this->searchClientInterfaceMock->expects($this->atLeastOnce())
            ->method('expandQuery')
            ->willReturn($this->queryInterfaceMock);

        $this->assertInstanceOf(QueryInterface::class, $this->priceProductPriceListPageSearchToSearchClientBridge->expandQuery($this->queryInterfaceMock, $this->searchQueryExpanders));
    }
}
