<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Communication;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailabilityPageSearch\ConditionalAvailabilityPageSearchDependencyProvider;
use FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Dependency\Facade\ConditionalAvailabilityPageSearchToEventBehaviorFacadeBridge;
use FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Dependency\Facade\ConditionalAvailabilityPageSearchToStoreFacadeInterface;
use Spryker\Zed\Kernel\Container;

class ConditionalAvailabilityPageSearchCommunicationFactoryTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Communication\ConditionalAvailabilityPageSearchCommunicationFactory
     */
    protected $conditionalAvailabilityPageSearchCommunicationFactory;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Container
     */
    protected $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Dependency\Facade\ConditionalAvailabilityPageSearchToStoreFacadeInterface
     */
    protected $conditionalAvailabilityPageSearchToStoreFacadeInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Dependency\Facade\ConditionalAvailabilityPageSearchToEventBehaviorFacadeInterface
     */
    protected $conditionalAvailabilityPageSearchToEventBehaviorFacadeBridgeMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityPageSearchToStoreFacadeInterfaceMock = $this->getMockBuilder(ConditionalAvailabilityPageSearchToStoreFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityPageSearchToEventBehaviorFacadeBridgeMock = $this->getMockBuilder(ConditionalAvailabilityPageSearchToEventBehaviorFacadeBridge::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->conditionalAvailabilityPageSearchCommunicationFactory = new ConditionalAvailabilityPageSearchCommunicationFactory();
        $this->conditionalAvailabilityPageSearchCommunicationFactory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testGetEventBehaviorFacade(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->with(ConditionalAvailabilityPageSearchDependencyProvider::FACADE_EVENT_BEHAVIOR)
            ->willReturn($this->conditionalAvailabilityPageSearchToEventBehaviorFacadeBridgeMock);

        $this->assertInstanceOf(
            ConditionalAvailabilityPageSearchToEventBehaviorFacadeBridge::class,
            $this->conditionalAvailabilityPageSearchCommunicationFactory->getEventBehaviorFacade(),
        );
    }
}
