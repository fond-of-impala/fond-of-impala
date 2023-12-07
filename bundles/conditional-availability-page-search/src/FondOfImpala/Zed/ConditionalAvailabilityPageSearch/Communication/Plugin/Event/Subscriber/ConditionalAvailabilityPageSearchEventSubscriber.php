<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Communication\Plugin\Event\Subscriber;

use FondOfImpala\Zed\ConditionalAvailability\Dependency\ConditionalAvailabilityEvents;
use FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Communication\Plugin\Event\Listener\ConditionalAvailabilityPeriodPageSearchListener;
use Spryker\Zed\Event\Dependency\EventCollectionInterface;
use Spryker\Zed\Event\Dependency\Plugin\EventSubscriberInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\ConditionalAvailabilityPageSearchConfig getConfig()
 * @method \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Persistence\ConditionalAvailabilityPageSearchQueryContainerInterface getQueryContainer()
 * @method \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\ConditionalAvailabilityPageSearchFacadeInterface getFacade()
 */
class ConditionalAvailabilityPageSearchEventSubscriber extends AbstractPlugin implements EventSubscriberInterface
{
    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return \Spryker\Zed\Event\Dependency\EventCollectionInterface
     */
    public function getSubscribedEvents(EventCollectionInterface $eventCollection): EventCollectionInterface
    {
        $this->addConditionalAvailabilityPeriodCreateListener($eventCollection);
        $this->addConditionalAvailabilityPeriodUpdateListener($eventCollection);
        $this->addConditionalAvailabilityPeriodDeleteListener($eventCollection);

        $this->addConditionalAvailabilityPeriodPublishListener($eventCollection);
        $this->addConditionalAvailabilityPeriodUnpublishListener($eventCollection);

        return $eventCollection;
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addConditionalAvailabilityPeriodPublishListener(
        EventCollectionInterface $eventCollection
    ): void {
        $eventCollection->addListenerQueued(
            ConditionalAvailabilityEvents::CONDITIONAL_AVAILABILITY_PERIOD_PUBLISH,
            new ConditionalAvailabilityPeriodPageSearchListener(),
        );
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addConditionalAvailabilityPeriodCreateListener(
        EventCollectionInterface $eventCollection
    ): void {
        $eventCollection->addListenerQueued(
            ConditionalAvailabilityEvents::ENTITY_FOI_CONDITIONAL_AVAILABILITY_PERIOD_CREATE,
            new ConditionalAvailabilityPeriodPageSearchListener(),
        );
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addConditionalAvailabilityPeriodUpdateListener(
        EventCollectionInterface $eventCollection
    ): void {
        $eventCollection->addListenerQueued(
            ConditionalAvailabilityEvents::ENTITY_FOI_CONDITIONAL_AVAILABILITY_PERIOD_UPDATE,
            new ConditionalAvailabilityPeriodPageSearchListener(),
        );
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addConditionalAvailabilityPeriodDeleteListener(
        EventCollectionInterface $eventCollection
    ): void {
        $eventCollection->addListenerQueued(
            ConditionalAvailabilityEvents::ENTITY_FOI_CONDITIONAL_AVAILABILITY_PERIOD_DELETE,
            new ConditionalAvailabilityPeriodPageSearchListener(),
        );
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addConditionalAvailabilityPeriodUnpublishListener(
        EventCollectionInterface $eventCollection
    ): void {
        $eventCollection->addListenerQueued(
            ConditionalAvailabilityEvents::CONDITIONAL_AVAILABILITY_PERIOD_UNPUBLISH,
            new ConditionalAvailabilityPeriodPageSearchListener(),
        );
    }
}
