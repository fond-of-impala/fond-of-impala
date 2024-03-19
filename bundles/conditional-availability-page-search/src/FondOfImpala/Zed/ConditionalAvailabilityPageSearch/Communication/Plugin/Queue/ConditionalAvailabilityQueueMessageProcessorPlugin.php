<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Communication\Plugin\Queue;

use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\Queue\Dependency\Plugin\QueueMessageProcessorPluginInterface;

/**
 * @method \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Communication\ConditionalAvailabilityPageSearchCommunicationFactory getFactory()
 * @method \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\ConditionalAvailabilityPageSearchConfig getConfig()
 */
class ConditionalAvailabilityQueueMessageProcessorPlugin extends AbstractPlugin implements QueueMessageProcessorPluginInterface
{
    /**
     * @param array<\Generated\Shared\Transfer\QueueReceiveMessageTransfer> $queueMessageTransfers
     *
     * @return array<\Generated\Shared\Transfer\QueueReceiveMessageTransfer>
     */
    public function processMessages(array $queueMessageTransfers)
    {
        return $this->getFactory()->getEventFacade()->processEnqueuedMessages($queueMessageTransfers);
    }

    /**
     * @return int
     */
    public function getChunkSize()
    {
        return $this->getConfig()->getEventChunkSize();
    }
}
