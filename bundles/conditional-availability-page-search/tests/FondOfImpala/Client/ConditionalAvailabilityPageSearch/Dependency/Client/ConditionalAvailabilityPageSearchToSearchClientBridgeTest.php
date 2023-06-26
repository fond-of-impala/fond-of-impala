<?php

namespace FondOfImpala\Client\ConditionalAvailabilityPageSearch\Dependency\Client;

use Codeception\Test\Unit;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Client\Search\SearchClientInterface;
use Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface;

class ConditionalAvailabilityPageSearchToSearchClientBridgeTest extends Unit
{
    /**
     * @var \FondOfImpala\Client\ConditionalAvailabilityPageSearch\Dependency\Client\ConditionalAvailabilityPageSearchToSearchClientBridge
     */
    protected ConditionalAvailabilityPageSearchToSearchClientBridge $bridge;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\Search\SearchClientInterface
     */
    protected MockObject|SearchClientInterface $searchClientMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface
     */
    protected MockObject|QueryInterface $queryMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->searchClientMock = $this->getMockBuilder(SearchClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->queryMock = $this->getMockBuilder(QueryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bridge = new ConditionalAvailabilityPageSearchToSearchClientBridge($this->searchClientMock);
    }

    /**
     * @return void
     */
    public function testSearch(): void
    {
        $this->searchClientMock->expects($this->atLeastOnce())
            ->method('search')
            ->with($this->queryMock)
            ->willReturn([]);

        static::assertIsArray($this->bridge->search($this->queryMock));
    }

    /**
     * @return void
     */
    public function testExpandQuery(): void
    {
        $this->searchClientMock->expects($this->atLeastOnce())
            ->method('expandQuery')
            ->with($this->queryMock, [])
            ->willReturn($this->queryMock);

        $query = $this->bridge->expandQuery($this->queryMock, []);

        static::assertEquals($this->queryMock, $query);
    }
}
