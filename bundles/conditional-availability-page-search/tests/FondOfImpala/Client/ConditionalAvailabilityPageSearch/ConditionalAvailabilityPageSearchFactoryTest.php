<?php

namespace FondOfImpala\Client\ConditionalAvailabilityPageSearch;

use Codeception\Test\Unit;
use FondOfImpala\Client\ConditionalAvailabilityPageSearch\Dependency\Client\ConditionalAvailabilityPageSearchToCustomerClientInterface;
use FondOfImpala\Client\ConditionalAvailabilityPageSearch\Dependency\Client\ConditionalAvailabilityPageSearchToSearchClientInterface;
use Spryker\Client\Kernel\Container;
use Spryker\Client\Search\Dependency\Plugin\QueryInterface;

class ConditionalAvailabilityPageSearchFactoryTest extends Unit
{
    /**
     * @var \FondOfImpala\Client\ConditionalAvailabilityPageSearch\ConditionalAvailabilityPageSearchFactory
     */
    protected $conditionalAvailabilityPageSearchFactory;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\Kernel\Container
     */
    protected $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Client\ConditionalAvailabilityPageSearch\Dependency\Client\ConditionalAvailabilityPageSearchToSearchClientInterface
     */
    protected $conditionalAvailabilityPageSearchToSearchClientInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Client\ConditionalAvailabilityPageSearch\Dependency\Client\ConditionalAvailabilityPageSearchToCustomerClientInterface
     */
    protected $conditionalAvailabilityPageSearchToCustomerClientInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\Search\Dependency\Plugin\QueryInterface
     */
    protected $queryInterfaceMock;

    /**
     * @var string
     */
    protected $searchString;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityPageSearchToSearchClientInterfaceMock = $this->getMockBuilder(ConditionalAvailabilityPageSearchToSearchClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityPageSearchToCustomerClientInterfaceMock = $this->getMockBuilder(ConditionalAvailabilityPageSearchToCustomerClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->queryInterfaceMock = $this->getMockBuilder(QueryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->searchString = 'search-string';

        $this->conditionalAvailabilityPageSearchFactory = new ConditionalAvailabilityPageSearchFactory();
        $this->conditionalAvailabilityPageSearchFactory->setContainer($this->containerMock);
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
            ->with(ConditionalAvailabilityPageSearchDependencyProvider::CLIENT_SEARCH)
            ->willReturn($this->conditionalAvailabilityPageSearchToSearchClientInterfaceMock);

        $this->assertInstanceOf(
            ConditionalAvailabilityPageSearchToSearchClientInterface::class,
            $this->conditionalAvailabilityPageSearchFactory->getSearchClient(),
        );
    }

    /**
     * @return void
     */
    public function testGetCustomerClient(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->with(ConditionalAvailabilityPageSearchDependencyProvider::CLIENT_CUSTOMER)
            ->willReturn($this->conditionalAvailabilityPageSearchToCustomerClientInterfaceMock);

        $this->assertInstanceOf(
            ConditionalAvailabilityPageSearchToCustomerClientInterface::class,
            $this->conditionalAvailabilityPageSearchFactory->getCustomerClient(),
        );
    }

    /**
     * @return void
     */
    public function testCreateSearchQuery(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->with(ConditionalAvailabilityPageSearchDependencyProvider::PLUGIN_SEARCH_QUERY)
            ->willReturn($this->queryInterfaceMock);

        $this->assertInstanceOf(
            QueryInterface::class,
            $this->conditionalAvailabilityPageSearchFactory->createSearchQuery(
                $this->searchString,
            ),
        );
    }

    /**
     * @return void
     */
    public function testGetSearchQueryExpanderPlugins(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->with(ConditionalAvailabilityPageSearchDependencyProvider::PLUGINS_SEARCH_QUERY_EXPANDER)
            ->willReturn([]);

        $this->assertIsArray(
            $this->conditionalAvailabilityPageSearchFactory->getSearchQueryExpanderPlugins(),
        );
    }

    /**
     * @return void
     */
    public function testGetSearchResultFormatterPlugins(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->with(ConditionalAvailabilityPageSearchDependencyProvider::PLUGINS_SEARCH_RESULT_FORMATTER)
            ->willReturn([]);

        $this->assertIsArray(
            $this->conditionalAvailabilityPageSearchFactory->getSearchResultFormatterPlugins(),
        );
    }
}
