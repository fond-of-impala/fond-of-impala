<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Expander\ProductPageLoadExpander;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\Trigger\StockStatusTrigger;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\ConditionalAvailabilityProductPageSearchDependencyProvider;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToConditionalAvailabilityFacadeInterface;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToEventBehaviorFacadeInterface;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToProductFacadeInterface;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Persistence\ConditionalAvailabilityProductPageSearchRepository;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Kernel\Container;

class ConditionalAvailabilityProductPageSearchBusinessFactoryTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Container
     */
    protected MockObject|Container $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToConditionalAvailabilityFacadeInterface
     */
    protected MockObject|ConditionalAvailabilityProductPageSearchToConditionalAvailabilityFacadeInterface $conditionalAvailabilityFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToProductFacadeInterface
     */
    protected MockObject|ConditionalAvailabilityProductPageSearchToProductFacadeInterface $productFacadeMock;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Business\ConditionalAvailabilityProductPageSearchBusinessFactory
     */
    protected ConditionalAvailabilityProductPageSearchBusinessFactory $factory;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToEventBehaviorFacadeInterface
     */
    protected MockObject|ConditionalAvailabilityProductPageSearchToEventBehaviorFacadeInterface $eventBehaviorFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Persistence\ConditionalAvailabilityProductPageSearchRepository
     */
    protected MockObject|ConditionalAvailabilityProductPageSearchRepository $repositoryMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityFacadeMock = $this->getMockBuilder(ConditionalAvailabilityProductPageSearchToConditionalAvailabilityFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->repositoryMock = $this->getMockBuilder(ConditionalAvailabilityProductPageSearchRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->eventBehaviorFacadeMock = $this->getMockBuilder(ConditionalAvailabilityProductPageSearchToEventBehaviorFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factory = new ConditionalAvailabilityProductPageSearchBusinessFactory();
        $this->factory->setContainer($this->containerMock);
        $this->factory->setRepository($this->repositoryMock);
    }

    /**
     * @return void
     */
    public function testCreateProductPageLoadExpander(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->with(ConditionalAvailabilityProductPageSearchDependencyProvider::FACADE_CONDITIONAL_AVAILABILITY)
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->with(ConditionalAvailabilityProductPageSearchDependencyProvider::FACADE_CONDITIONAL_AVAILABILITY)
            ->willReturn($this->conditionalAvailabilityFacadeMock);

        static::assertInstanceOf(
            ProductPageLoadExpander::class,
            $this->factory->createProductPageLoadExpander(),
        );
    }

    /**
     * @return void
     */
    public function testCreateStockStatusTrigger(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->with(ConditionalAvailabilityProductPageSearchDependencyProvider::FACADE_EVENT_BEHAVIOR)
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->with(ConditionalAvailabilityProductPageSearchDependencyProvider::FACADE_EVENT_BEHAVIOR)
            ->willReturn($this->eventBehaviorFacadeMock);

        static::assertInstanceOf(
            StockStatusTrigger::class,
            $this->factory->createStockStatusTrigger(),
        );
    }
}
