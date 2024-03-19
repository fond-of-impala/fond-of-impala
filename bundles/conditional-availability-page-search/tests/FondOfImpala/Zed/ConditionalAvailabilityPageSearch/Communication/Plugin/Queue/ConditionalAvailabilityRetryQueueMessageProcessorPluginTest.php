<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Communication\Plugin\Queue;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Communication\ConditionalAvailabilityPageSearchCommunicationFactory;
use FondOfImpala\Zed\ConditionalAvailabilityPageSearch\ConditionalAvailabilityPageSearchConfig;
use FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Dependency\Facade\ConditionalAvailabilityPageSearchToEventFacadeInterface;
use Generated\Shared\Transfer\QueueReceiveMessageTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ConditionalAvailabilityRetryQueueMessageProcessorPluginTest extends Unit
{
    protected MockObject|ConditionalAvailabilityPageSearchCommunicationFactory $factoryMock;

    protected ConditionalAvailabilityPageSearchToEventFacadeInterface|MockObject $eventFacadeMock;

    protected MockObject|QueueReceiveMessageTransfer $queueReceiveMessageTransferMock;

    protected ConditionalAvailabilityPageSearchConfig|MockObject $configMock;

    protected ConditionalAvailabilityRetryQueueMessageProcessorPlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->factoryMock = $this->getMockBuilder(ConditionalAvailabilityPageSearchCommunicationFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->eventFacadeMock = $this->getMockBuilder(ConditionalAvailabilityPageSearchToEventFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->queueReceiveMessageTransferMock = $this->getMockBuilder(QueueReceiveMessageTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->configMock = $this->getMockBuilder(ConditionalAvailabilityPageSearchConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new ConditionalAvailabilityRetryQueueMessageProcessorPlugin();
        $this->plugin->setConfig($this->configMock);
        $this->plugin->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testGetChunkSize(): void
    {
        $chunkSize = 1000;

        $this->configMock->expects(static::atLeastOnce())
            ->method('getEventChunkSize')
            ->willReturn($chunkSize);

        static::assertEquals(
            $chunkSize,
            $this->plugin->getChunkSize(),
        );
    }

    /**
     * @return void
     */
    public function testProcessMessages(): void
    {
        $queueReceiveMessageTransferMocks = [
            $this->queueReceiveMessageTransferMock,
        ];

        $this->factoryMock->expects(static::atLeastOnce())
            ->method('getEventFacade')
            ->willReturn($this->eventFacadeMock);

        $this->eventFacadeMock->expects(static::atLeastOnce())
            ->method('forwardMessages')
            ->with($queueReceiveMessageTransferMocks)
            ->willReturn($queueReceiveMessageTransferMocks);

        static::assertEquals(
            $queueReceiveMessageTransferMocks,
            $this->plugin->processMessages($queueReceiveMessageTransferMocks),
        );
    }
}
