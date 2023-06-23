<?php

namespace FondOfImpala\Client\ConditionalAvailabilityPageSearch;

use Codeception\Test\Unit;
use FondOfImpala\Client\ConditionalAvailabilityPageSearch\Dependency\Client\ConditionalAvailabilityPageSearchToSearchClientInterface;
use Spryker\Client\Search\Dependency\Plugin\QueryInterface;
use PHPUnit\Framework\MockObject\MockObject;

class ConditionalAvailabilityPageSearchClientTest extends Unit
{
    /**
     * @var \FondOfImpala\Client\ConditionalAvailabilityPageSearch\ConditionalAvailabilityPageSearchClient
     */
    protected ConditionalAvailabilityPageSearchClient $client;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Client\ConditionalAvailabilityPageSearch\ConditionalAvailabilityPageSearchFactory
     */
    protected MockObject|ConditionalAvailabilityPageSearchFactory $factoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\Search\Dependency\Plugin\QueryInterface
     */
    protected MockObject|QueryInterface $queryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Client\ConditionalAvailabilityPageSearch\Dependency\Client\ConditionalAvailabilityPageSearchToSearchClientInterface
     */
    protected MockObject|ConditionalAvailabilityPageSearchToSearchClientInterface $searchClientMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->factoryMock = $this->getMockBuilder(ConditionalAvailabilityPageSearchFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->queryMock = $this->getMockBuilder(QueryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->searchClientMock = $this->getMockBuilder(ConditionalAvailabilityPageSearchToSearchClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->client = new ConditionalAvailabilityPageSearchClient();
        $this->client->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testSearch(): void
    {
        $searchString = 'search-string';

        $this->factoryMock->expects($this->atLeastOnce())
            ->method('createSearchQuery')
            ->willReturn($this->queryMock);

        $this->factoryMock->expects($this->atLeastOnce())
            ->method('getSearchClient')
            ->willReturn($this->searchClientMock);

        $this->factoryMock->expects($this->atLeastOnce())
            ->method('getSearchQueryExpanderPlugins')
            ->willReturn([]);

        $this->searchClientMock->expects($this->atLeastOnce())
            ->method('expandQuery')
            ->with($this->queryMock, [], [])
            ->willReturn($this->queryMock);

        $this->factoryMock->expects($this->atLeastOnce())
            ->method('getSearchResultFormatterPlugins')
            ->willReturn([]);

        $this->searchClientMock->expects($this->atLeastOnce())
            ->method('search')
            ->with($this->queryMock, [], [])
            ->willReturn([]);

        static::assertIsArray(
            $this->client->search($searchString),
        );
    }
}
