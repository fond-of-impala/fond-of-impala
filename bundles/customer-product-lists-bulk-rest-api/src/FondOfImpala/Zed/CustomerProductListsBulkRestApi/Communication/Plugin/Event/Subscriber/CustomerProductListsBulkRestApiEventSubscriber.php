<?php

namespace FondOfImpala\Zed\CustomerProductListsBulkRestApi\Communication\Plugin\Event\Subscriber;

use FondOfImpala\Zed\CustomerProductListsBulkRestApi\Communication\Plugin\Event\Listener\CustomerProductListsAssignmentEventListener;
use FondOfImpala\Zed\ProductListsBulkRestApi\Dependency\ProductListsBulkRestApiEvents;
use Spryker\Zed\Event\Dependency\EventCollectionInterface;
use Spryker\Zed\Event\Dependency\Plugin\EventSubscriberInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

class CustomerProductListsBulkRestApiEventSubscriber extends AbstractPlugin implements EventSubscriberInterface
{
    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return \Spryker\Zed\Event\Dependency\EventCollectionInterface
     */
    public function getSubscribedEvents(EventCollectionInterface $eventCollection): EventCollectionInterface
    {
        return $eventCollection->addListenerQueued(
            ProductListsBulkRestApiEvents::ASSIGNMENT_PROCESS,
            new CustomerProductListsAssignmentEventListener(),
        );
    }
}
