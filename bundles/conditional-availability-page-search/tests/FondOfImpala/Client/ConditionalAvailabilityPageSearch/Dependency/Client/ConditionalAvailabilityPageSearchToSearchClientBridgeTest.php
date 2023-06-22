<?php

namespace FondOfImpala\Client\ConditionalAvailabilityPageSearch\Dependency\Client;

use Codeception\Test\Unit;
use Spryker\Client\Search\SearchClientInterface;
use Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface;

class ConditionalAvailabilityPageSearchToSearchClientBridgeTest extends Unit
{
    /**
     * @var \FondOfImpala\Client\ConditionalAvailabilityPageSearch\Dependency\Client\ConditionalAvailabilityPageSearchToSearchClientBridge
     */
    protected $conditionalAvailabilityPageSearchToSearchClientBridge;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\Search\SearchClientInterface
     */
    protected $searchClientInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface
     */
    protected $queryInterfaceMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->searchClientInterfaceMock = $this->getMockBuilder(SearchClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->queryInterfaceMock = $this->getMockBuilder(QueryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityPageSearchToSearchClientBridge = new ConditionalAvailabilityPageSearchToSearchClientBridge(
            $this->searchClientInterfaceMock,
        );
    }

    /**
     * @return void
     */
    public function testSearch(): void
    {
        $this->searchClientInterfaceMock->expects($this->atLeastOnce())
            ->method('search')
            ->with($this->queryInterfaceMock)
            ->willReturn([]);

        $this->assertIsArray(
            $this->conditionalAvailabilityPageSearchToSearchClientBridge->search(
                $this->queryInterfaceMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testExpandQuery(): void
    {
        $this->searchClientInterfaceMock->expects($this->atLeastOnce())
            ->method('expandQuery')
            ->with($this->queryInterfaceMock, [])
            ->willReturn($this->queryInterfaceMock);

        $this->assertInstanceOf(
            QueryInterface::class,
            $this->conditionalAvailabilityPageSearchToSearchClientBridge->expandQuery(
                $this->queryInterfaceMock,
                [],
            ),
        );
    }
}
