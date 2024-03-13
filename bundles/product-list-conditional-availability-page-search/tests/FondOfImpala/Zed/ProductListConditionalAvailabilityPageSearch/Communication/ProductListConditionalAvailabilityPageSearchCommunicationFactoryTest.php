<?php

namespace FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Communication;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Dependency\Facade\ProductListConditionalAvailabilityPageSearchToConditionalAvailabilityFacadeInterface;
use FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Dependency\Facade\ProductListConditionalAvailabilityPageSearchToEventBehaviorFacadeInterface;
use FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\ProductListConditionalAvailabilityPageSearchDependencyProvider;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Kernel\Container;

class ProductListConditionalAvailabilityPageSearchCommunicationFactoryTest extends Unit
{
    protected ProductListConditionalAvailabilityPageSearchCommunicationFactory $factory;

    protected MockObject|Container $containerMock;

    protected MockObject|ProductListConditionalAvailabilityPageSearchToConditionalAvailabilityFacadeInterface $conditionalAvailabilityFacadeMock;

    protected MockObject|ProductListConditionalAvailabilityPageSearchToEventBehaviorFacadeInterface $eventBehaviorFacadeMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityFacadeMock = $this->getMockBuilder(ProductListConditionalAvailabilityPageSearchToConditionalAvailabilityFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->eventBehaviorFacadeMock = $this->getMockBuilder(ProductListConditionalAvailabilityPageSearchToEventBehaviorFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factory = new ProductListConditionalAvailabilityPageSearchCommunicationFactory();
        $this->factory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testGetConditionalAvailabilityFacade(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->with(ProductListConditionalAvailabilityPageSearchDependencyProvider::FACADE_CONDITIONAL_AVAILABILITY)
            ->willReturn($this->conditionalAvailabilityFacadeMock);

        static::assertEquals(
            $this->conditionalAvailabilityFacadeMock,
            $this->factory->getConditionalAvailabilityFacade(),
        );
    }

    /**
     * @return void
     */
    public function testGetEventBehaviorFacade(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->with(ProductListConditionalAvailabilityPageSearchDependencyProvider::FACADE_EVENT_BEHAVIOR)
            ->willReturn($this->eventBehaviorFacadeMock);

        static::assertEquals($this->eventBehaviorFacadeMock, $this->factory->getEventBehaviorFacade());
    }
}
