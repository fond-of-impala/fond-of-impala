<?php

namespace FondOfImpala\Zed\ConditionalAvailabilitySearch\Communication\Plugin\Event\Subscriber;

use FondOfImpala\Zed\ConditionalAvailability\Dependency\ConditionalAvailabilityEvents;
use FondOfImpala\Zed\ConditionalAvailabilitySearch\Communication\Plugin\Event\Listener\ConditionalAvailabilityProductConcretePageSearchPublishListener;
use Spryker\Zed\Event\Dependency\EventCollectionInterface;
use Spryker\Zed\Event\Dependency\Plugin\EventSubscriberInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

class ConditionalAvailabilitySearchEventSubscriber extends AbstractPlugin implements EventSubscriberInterface
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
        $this->addConditionalAvailabilityCreateProductConcretePageSearchPublishListener($eventCollection);

        return $eventCollection;
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addConditionalAvailabilityCreateProductConcretePageSearchPublishListener(EventCollectionInterface $eventCollection): void
    {
        $eventCollection->addListenerQueued(
            ConditionalAvailabilityEvents::ENTITY_FOI_CONDITIONAL_AVAILABILITY_CREATE,
            new ConditionalAvailabilityProductConcretePageSearchPublishListener(),
            0,
            null,
            $this->getConfig()->getEventQueueName()
        );
    }

}
