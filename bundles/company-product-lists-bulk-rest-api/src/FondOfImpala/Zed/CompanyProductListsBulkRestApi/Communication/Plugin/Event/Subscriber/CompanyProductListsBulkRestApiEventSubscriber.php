<?php

namespace FondOfImpala\Zed\CompanyProductListsBulkRestApi\Communication\Plugin\Event\Subscriber;

use FondOfImpala\Zed\ProductListsBulkRestApi\Dependency\ProductListsBulkRestApiEvents;
use Spryker\Zed\Event\Dependency\EventCollectionInterface;
use Spryker\Zed\Event\Dependency\Plugin\EventSubscriberInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

class CompanyProductListsBulkRestApiEventSubscriber extends AbstractPlugin implements EventSubscriberInterface
{

    public function getSubscribedEvents(EventCollectionInterface $eventCollection)
    {
        $eventCollection->addListenerQueued(
            ProductListsBulkRestApiEvents::ASSIGNMENT_PROCESS,

        )
    }
}
