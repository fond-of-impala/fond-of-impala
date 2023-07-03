<?php

namespace FondOfImpala\Client\ConditionalAvailabilityPageSearch;

use Codeception\Test\Unit;
use FondOfImpala\Client\ConditionalAvailabilityPageSearch\Dependency\Client\ConditionalAvailabilityPageSearchToCustomerClientInterface;
use FondOfImpala\Client\ConditionalAvailabilityPageSearch\Dependency\Client\ConditionalAvailabilityPageSearchToSearchClientInterface;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Client\Kernel\Container;
use Spryker\Client\Search\Dependency\Plugin\QueryInterface;

class ConditionalAvailabilityPageSearchFactoryTest extends Unit
{
    /**
     * @var \FondOfImpala\Client\ConditionalAvailabilityPageSearch\ConditionalAvailabilityPageSearchFactory
     */
    protected ConditionalAvailabilityPageSearchFactory $factory;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\Kernel\Container
     */
    protected MockObject|Container $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Client\ConditionalAvailabilityPageSearch\Dependency\Client\ConditionalAvailabilityPageSearchToSearchClientInterface
     */
    protected MockObject|ConditionalAvailabilityPageSearchToSearchClientInterface $clientMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\Search\Dependency\Plugin\QueryInterface
     */
    protected MockObject|QueryInterface $queryMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->clientMock = $this->getMockBuilder(ConditionalAvailabilityPageSearchToSearchClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerClientMock = $this->getMockBuilder(ConditionalAvailabilityPageSearchToCustomerClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->queryMock = $this->getMockBuilder(QueryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factory = new ConditionalAvailabilityPageSearchFactory();
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
            ->with(ConditionalAvailabilityPageSearchDependencyProvider::CLIENT_SEARCH)
            ->willReturn($this->clientMock);

        static::assertInstanceOf(
            ConditionalAvailabilityPageSearchToSearchClientInterface::class,
            $this->factory->getSearchClient(),
        );
    }

    /**
     * @return void
     */
    public function testGetCustomerClient(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->with(ConditionalAvailabilityPageSearchDependencyProvider::CLIENT_CUSTOMER)
            ->willReturn($this->customerClientMock);

        static::assertEquals($this->customerClientMock, $this->factory->getCustomerClient());
    }

    /**
     * @return void
     */
    public function testCreateSearchQuery(): void
    {
        $searchString = 'search-string';
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->with(ConditionalAvailabilityPageSearchDependencyProvider::PLUGIN_SEARCH_QUERY)
            ->willReturn($this->queryMock);

        static::assertEquals($this->queryMock, $this->factory->createSearchQuery($searchString));
    }

    /**
     * @return void
     */
    public function testGetSearchQueryExpanderPlugins(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->with(ConditionalAvailabilityPageSearchDependencyProvider::PLUGINS_SEARCH_QUERY_EXPANDER)
            ->willReturn([]);

        static::assertIsArray($this->factory->getSearchQueryExpanderPlugins());
    }

    /**
     * @return void
     */
    public function testGetSearchResultFormatterPlugins(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->with(ConditionalAvailabilityPageSearchDependencyProvider::PLUGINS_SEARCH_RESULT_FORMATTER)
            ->willReturn([]);

        static::assertIsArray($this->factory->getSearchResultFormatterPlugins());
    }
}
