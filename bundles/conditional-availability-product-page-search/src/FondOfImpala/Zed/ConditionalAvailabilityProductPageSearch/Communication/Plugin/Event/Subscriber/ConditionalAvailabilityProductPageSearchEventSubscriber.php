<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Communication\Plugin\Event\Subscriber;

use FondOfImpala\Zed\ConditionalAvailability\Dependency\ConditionalAvailabilityEvents;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Communication\Plugin\Event\Listener\ConditionalAvailabilityProductConcretePageSearchPublishListener;
use Spryker\Zed\Event\Dependency\EventCollectionInterface;
use Spryker\Zed\Event\Dependency\Plugin\EventSubscriberInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

class ConditionalAvailabilityProductPageSearchEventSubscriber extends AbstractPlugin implements EventSubscriberInterface
{
    /**
     * @api
     *
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return \Spryker\Zed\Event\Dependency\EventCollectionInterface
     */
    public function getSubscribedEvents(EventCollectionInterface $eventCollection): EventCollectionInterface
    {
        $eventCollection->addListenerQueued(
            ConditionalAvailabilityEvents::ENTITY_FOI_CONDITIONAL_AVAILABILITY_CREATE,
            new ConditionalAvailabilityProductConcretePageSearchPublishListener(),
        );

        return $eventCollection;
    }
}
