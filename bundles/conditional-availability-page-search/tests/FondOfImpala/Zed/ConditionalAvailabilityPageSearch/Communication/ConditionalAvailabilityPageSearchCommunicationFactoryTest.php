<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Communication;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailabilityPageSearch\ConditionalAvailabilityPageSearchDependencyProvider;
use FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Dependency\Facade\ConditionalAvailabilityPageSearchToEventBehaviorFacadeBridge;
use FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Dependency\Facade\ConditionalAvailabilityPageSearchToEventBehaviorFacadeInterface;
use FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Dependency\Facade\ConditionalAvailabilityPageSearchToStoreFacadeInterface;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Kernel\Container;

class ConditionalAvailabilityPageSearchCommunicationFactoryTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Communication\ConditionalAvailabilityPageSearchCommunicationFactory
     */
    protected ConditionalAvailabilityPageSearchCommunicationFactory $factory;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Container
     */
    protected MockObject|Container $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Dependency\Facade\ConditionalAvailabilityPageSearchToStoreFacadeInterface
     */
    protected MockObject|ConditionalAvailabilityPageSearchToStoreFacadeInterface $storeFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Dependency\Facade\ConditionalAvailabilityPageSearchToEventBehaviorFacadeInterface
     */
    protected MockObject|ConditionalAvailabilityPageSearchToEventBehaviorFacadeInterface $eventBehaviorFacadeMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->storeFacadeMock = $this->getMockBuilder(ConditionalAvailabilityPageSearchToStoreFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->eventBehaviorFacadeMock = $this->getMockBuilder(ConditionalAvailabilityPageSearchToEventBehaviorFacadeBridge::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factory = new ConditionalAvailabilityPageSearchCommunicationFactory();
        $this->factory->setContainer($this->containerMock);
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
            ->with(ConditionalAvailabilityPageSearchDependencyProvider::FACADE_EVENT_BEHAVIOR)
            ->willReturn($this->eventBehaviorFacadeMock);

        static::assertInstanceOf(
            ConditionalAvailabilityPageSearchToEventBehaviorFacadeBridge::class,
            $this->factory->getEventBehaviorFacade(),
        );
    }
}
