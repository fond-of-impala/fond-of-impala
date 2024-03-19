<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Communication;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailabilityPageSearch\ConditionalAvailabilityPageSearchDependencyProvider;
use FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Dependency\Facade\ConditionalAvailabilityPageSearchToEventFacadeInterface;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Kernel\Container;

class ConditionalAvailabilityPageSearchCommunicationFactoryTest extends Unit
{
    protected MockObject|Container $containerMock;

    protected MockObject|ConditionalAvailabilityPageSearchToEventFacadeInterface $eventFacadeMock;

    protected ConditionalAvailabilityPageSearchCommunicationFactory $factory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->eventFacadeMock = $this->getMockBuilder(ConditionalAvailabilityPageSearchToEventFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factory = new ConditionalAvailabilityPageSearchCommunicationFactory();
        $this->factory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testGetEventFacade(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->with(ConditionalAvailabilityPageSearchDependencyProvider::FACADE_EVENT)
            ->willReturn($this->eventFacadeMock);

        static::assertEquals(
            $this->eventFacadeMock,
            $this->factory->getEventFacade(),
        );
    }
}
