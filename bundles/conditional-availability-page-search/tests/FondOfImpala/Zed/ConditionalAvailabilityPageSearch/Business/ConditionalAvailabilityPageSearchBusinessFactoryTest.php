<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\Model\ConditionalAvailabilityPeriodPageSearchPublisher;
use FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\Model\ConditionalAvailabilityPeriodPageSearchUnpublisher;
use FondOfImpala\Zed\ConditionalAvailabilityPageSearch\ConditionalAvailabilityPageSearchDependencyProvider;
use FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Dependency\Facade\ConditionalAvailabilityPageSearchToStoreFacadeInterface;
use FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Dependency\Service\ConditionalAvailabilityPageSearchToUtilEncodingServiceInterface;
use FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Persistence\ConditionalAvailabilityPageSearchEntityManager;
use FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Persistence\ConditionalAvailabilityPageSearchQueryContainer;
use Spryker\Zed\Kernel\Container;

class ConditionalAvailabilityPageSearchBusinessFactoryTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\ConditionalAvailabilityPageSearchBusinessFactory
     */
    protected $conditionalAvailabilityPageSearchBusinessFactory;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Persistence\ConditionalAvailabilityPageSearchQueryContainer
     */
    protected $conditionalAvailabilityPageSearchQueryContainerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Persistence\ConditionalAvailabilityPageSearchEntityManager
     */
    protected $conditionalAvailabilityPageSearchEntityManagerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Container
     */
    protected $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Dependency\Facade\ConditionalAvailabilityPageSearchToStoreFacadeInterface
     */
    protected $conditionalAvailabilityPageSearchToStoreFacadeMock;

    /**
     * @var array<\FondOfImpala\Zed\ConditionalAvailabilityPageSearchExtension\Dependency\Plugin\ConditionalAvailabilityPeriodPageDataExpanderPluginInterface>
     */
    protected $conditionalAvailabilityPeriodPageDataExpanderPluginMocks;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Dependency\Service\ConditionalAvailabilityPageSearchToUtilEncodingServiceInterface
     */
    protected $conditionalAvailabilityPageSearchToUtilEncodingServiceMock;

    /**
     * @var array<\FondOfImpala\Zed\ConditionalAvailabilityPageSearchExtension\Dependency\Plugin\ConditionalAvailabilityPeriodPageSearchDataExpanderPluginInterface>
     */
    protected $conditionalAvailabilityPeriodPageSearchDataExpanderPluginMocks;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->conditionalAvailabilityPageSearchQueryContainerMock = $this->getMockBuilder(ConditionalAvailabilityPageSearchQueryContainer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityPageSearchEntityManagerMock = $this->getMockBuilder(ConditionalAvailabilityPageSearchEntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityPageSearchToStoreFacadeMock = $this->getMockBuilder(ConditionalAvailabilityPageSearchToStoreFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityPeriodPageDataExpanderPluginMocks = [];

        $this->conditionalAvailabilityPageSearchToUtilEncodingServiceMock = $this->getMockBuilder(ConditionalAvailabilityPageSearchToUtilEncodingServiceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityPeriodPageSearchDataExpanderPluginMocks = [];

        $this->conditionalAvailabilityPageSearchBusinessFactory = new ConditionalAvailabilityPageSearchBusinessFactory();
        $this->conditionalAvailabilityPageSearchBusinessFactory->setQueryContainer($this->conditionalAvailabilityPageSearchQueryContainerMock);
        $this->conditionalAvailabilityPageSearchBusinessFactory->setEntityManager($this->conditionalAvailabilityPageSearchEntityManagerMock);
        $this->conditionalAvailabilityPageSearchBusinessFactory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testCreateConditionalAvailabilityPeriodPageSearchPublisher(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->withConsecutive(
                [ConditionalAvailabilityPageSearchDependencyProvider::FACADE_STORE],
                [ConditionalAvailabilityPageSearchDependencyProvider::PLUGINS_CONDITIONAL_AVAILABILITY_PERIOD_PAGE_DATA_EXPANDER],
                [ConditionalAvailabilityPageSearchDependencyProvider::SERVICE_UTIL_ENCODING],
                [ConditionalAvailabilityPageSearchDependencyProvider::FACADE_STORE],
                [ConditionalAvailabilityPageSearchDependencyProvider::PLUGINS_CONDITIONAL_AVAILABILITY_PERIOD_PAGE_SEARCH_DATA_EXPANDER],
            )->willReturnOnConsecutiveCalls(
                $this->conditionalAvailabilityPageSearchToStoreFacadeMock,
                $this->conditionalAvailabilityPeriodPageDataExpanderPluginMocks,
                $this->conditionalAvailabilityPageSearchToUtilEncodingServiceMock,
                $this->conditionalAvailabilityPageSearchToStoreFacadeMock,
                $this->conditionalAvailabilityPeriodPageSearchDataExpanderPluginMocks,
            );

        $this->assertInstanceOf(
            ConditionalAvailabilityPeriodPageSearchPublisher::class,
            $this->conditionalAvailabilityPageSearchBusinessFactory->createConditionalAvailabilityPeriodPageSearchPublisher(),
        );
    }

    /**
     * @return void
     */
    public function testCreateConditionalAvailabilityPeriodPageSearchUnpublisher(): void
    {
        $this->assertInstanceOf(
            ConditionalAvailabilityPeriodPageSearchUnpublisher::class,
            $this->conditionalAvailabilityPageSearchBusinessFactory->createConditionalAvailabilityPeriodPageSearchUnpublisher(),
        );
    }
}
