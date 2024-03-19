<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Dependency\Facade;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\QueueReceiveMessageTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Event\Business\EventFacadeInterface;

class ConditionalAvailabilityPageSearchToEventFacadeBridgeTest extends Unit
{
    protected EventFacadeInterface|MockObject $facadeMock;

    protected MockObject|QueueReceiveMessageTransfer $queueReceiveMessageTransferMock;

    protected ConditionalAvailabilityPageSearchToEventFacadeBridge $bridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->facadeMock = $this->getMockBuilder(EventFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->queueReceiveMessageTransferMock = $this->getMockBuilder(QueueReceiveMessageTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bridge = new ConditionalAvailabilityPageSearchToEventFacadeBridge($this->facadeMock);
    }

    /**
     * @return void
     */
    public function testProcessEnqueuedMessages(): void
    {
        $queueReceiveMessageTransferMocks = [
            $this->queueReceiveMessageTransferMock,
        ];

        $this->facadeMock->expects(static::atLeastOnce())
            ->method('processEnqueuedMessages')
            ->with($queueReceiveMessageTransferMocks)
            ->willReturn($queueReceiveMessageTransferMocks);

        static::assertEquals(
            $queueReceiveMessageTransferMocks,
            $this->bridge->processEnqueuedMessages($queueReceiveMessageTransferMocks),
        );
    }

    /**
     * @return void
     */
    public function testForwardMessages(): void
    {
        $queueReceiveMessageTransferMocks = [
            $this->queueReceiveMessageTransferMock,
        ];

        $this->facadeMock->expects(static::atLeastOnce())
            ->method('forwardMessages')
            ->with($queueReceiveMessageTransferMocks)
            ->willReturn($queueReceiveMessageTransferMocks);

        static::assertEquals(
            $queueReceiveMessageTransferMocks,
            $this->bridge->forwardMessages($queueReceiveMessageTransferMocks),
        );
    }
}
