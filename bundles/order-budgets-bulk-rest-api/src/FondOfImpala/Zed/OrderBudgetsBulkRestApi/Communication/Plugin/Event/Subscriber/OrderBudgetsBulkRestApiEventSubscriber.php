<?php

namespace FondOfImpala\Zed\OrderBudgetsBulkRestApi\Communication\Plugin\Event\Subscriber;

use FondOfImpala\Zed\OrderBudgetsBulkRestApi\Communication\Plugin\Event\Listener\OrderBudgetPersistProcessListener;
use FondOfImpala\Zed\OrderBudgetsBulkRestApi\Dependency\OrderBudgetsBulkRestApiEvents;
use Spryker\Zed\Event\Dependency\EventCollectionInterface;
use Spryker\Zed\Event\Dependency\Plugin\EventSubscriberInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

class OrderBudgetsBulkRestApiEventSubscriber extends AbstractPlugin implements EventSubscriberInterface
{
    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return \Spryker\Zed\Event\Dependency\EventCollectionInterface
     */
    public function getSubscribedEvents(EventCollectionInterface $eventCollection): EventCollectionInterface
    {
        return $eventCollection->addListenerQueued(
            OrderBudgetsBulkRestApiEvents::PERSIST_PROCESS,
            new OrderBudgetPersistProcessListener(),
        );
    }
}
