<?php

namespace FondOfImpala\Client\ConditionalAvailabilityPageSearch;

use Codeception\Test\Unit;
use FondOfImpala\Client\ConditionalAvailabilityPageSearch\Dependency\Client\ConditionalAvailabilityPageSearchToSearchClientInterface;
use Spryker\Client\Search\Dependency\Plugin\QueryInterface;

class ConditionalAvailabilityPageSearchClientTest extends Unit
{
    /**
     * @var \FondOfImpala\Client\ConditionalAvailabilityPageSearch\ConditionalAvailabilityPageSearchClient
     */
    protected $conditionalAvailabilityPageSearchClient;

    /**
     * @var string
     */
    protected $searchString;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Client\ConditionalAvailabilityPageSearch\ConditionalAvailabilityPageSearchFactory
     */
    protected $conditionalAvailabilityPageSearchFactoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\Search\Dependency\Plugin\QueryInterface
     */
    protected $queryInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Client\ConditionalAvailabilityPageSearch\Dependency\Client\ConditionalAvailabilityPageSearchToSearchClientInterface
     */
    protected $conditionalAvailabilityPageSearchToSearchClientInterfaceMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->searchString = 'search-string';

        $this->conditionalAvailabilityPageSearchFactoryMock = $this->getMockBuilder(ConditionalAvailabilityPageSearchFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->queryInterfaceMock = $this->getMockBuilder(QueryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityPageSearchToSearchClientInterfaceMock = $this->getMockBuilder(ConditionalAvailabilityPageSearchToSearchClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityPageSearchClient = new ConditionalAvailabilityPageSearchClient();
        $this->conditionalAvailabilityPageSearchClient->setFactory($this->conditionalAvailabilityPageSearchFactoryMock);
    }

    /**
     * @return void
     */
    public function testSearch(): void
    {
        $this->conditionalAvailabilityPageSearchFactoryMock->expects($this->atLeastOnce())
            ->method('createSearchQuery')
            ->willReturn($this->queryInterfaceMock);

        $this->conditionalAvailabilityPageSearchFactoryMock->expects($this->atLeastOnce())
            ->method('getSearchClient')
            ->willReturn($this->conditionalAvailabilityPageSearchToSearchClientInterfaceMock);

        $this->conditionalAvailabilityPageSearchFactoryMock->expects($this->atLeastOnce())
            ->method('getSearchQueryExpanderPlugins')
            ->willReturn([]);

        $this->conditionalAvailabilityPageSearchToSearchClientInterfaceMock->expects($this->atLeastOnce())
            ->method('expandQuery')
            ->with($this->queryInterfaceMock, [], [])
            ->willReturn($this->queryInterfaceMock);

        $this->conditionalAvailabilityPageSearchFactoryMock->expects($this->atLeastOnce())
            ->method('getSearchResultFormatterPlugins')
            ->willReturn([]);

        $this->conditionalAvailabilityPageSearchToSearchClientInterfaceMock->expects($this->atLeastOnce())
            ->method('search')
            ->with($this->queryInterfaceMock, [], [])
            ->willReturn([]);

        $this->assertIsArray(
            $this->conditionalAvailabilityPageSearchClient->search(
                $this->searchString,
            ),
        );
    }
}
