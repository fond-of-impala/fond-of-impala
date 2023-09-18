<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade;

use Codeception\Test\Unit;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\EventBehavior\Business\EventBehaviorFacadeInterface;

class ConditionalAvailabilityProductPageSearchToEventBehaviorFacadeBridgeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\ConditionalAvailabilityProductPageSearchToEventBehaviorFacadeBridge
     */
    protected ConditionalAvailabilityProductPageSearchToEventBehaviorFacadeBridge $bridge;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Dependency\Facade\Spryker\Zed\EventBehavior\Business\EventBehaviorFacadeInterface
     */
    protected MockObject|EventBehaviorFacadeInterface $eventBehaviorFacadeMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->eventBehaviorFacadeMock = $this->getMockBuilder(EventBehaviorFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bridge = new ConditionalAvailabilityProductPageSearchToEventBehaviorFacadeBridge($this->eventBehaviorFacadeMock);
    }

    /**
     * @return void
     */
    public function testGetEventTransferIds(): void
    {
        $eventTransfers = [];
        $this->eventBehaviorFacadeMock->expects(static::atLeastOnce())
            ->method('getEventTransferIds')
            ->with($eventTransfers)
            ->willReturn([]);

        static::assertIsArray($this->bridge->getEventTransferIds($eventTransfers));
    }
}
