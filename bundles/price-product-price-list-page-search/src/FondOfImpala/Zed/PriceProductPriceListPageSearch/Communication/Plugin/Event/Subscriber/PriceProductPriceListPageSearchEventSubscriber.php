<?php

namespace FondOfImpala\Zed\PriceProductPriceListPageSearch\Communication\Plugin\Event\Subscriber;

use FondOfImpala\Zed\PriceProductPriceList\Dependency\PriceProductPriceListEvents;
use FondOfImpala\Zed\PriceProductPriceListPageSearch\Communication\Plugin\Event\Listener\PriceProductPriceListAbstractDeleteListener;
use FondOfImpala\Zed\PriceProductPriceListPageSearch\Communication\Plugin\Event\Listener\PriceProductPriceListAbstractListener;
use FondOfImpala\Zed\PriceProductPriceListPageSearch\Communication\Plugin\Event\Listener\PriceProductPriceListConcreteDeleteListener;
use FondOfImpala\Zed\PriceProductPriceListPageSearch\Communication\Plugin\Event\Listener\PriceProductPriceListConcreteListener;
use Spryker\Zed\Event\Dependency\EventCollectionInterface;
use Spryker\Zed\Event\Dependency\Plugin\EventSubscriberInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\PriceProductPriceListPageSearch\PriceProductPriceListPageSearchConfig getConfig()
 * @method \FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\PriceProductPriceListPageSearchFacadeInterface getFacade()
 * @method \FondOfImpala\Zed\PriceProductPriceListPageSearch\Communication\PriceProductPriceListPageSearchCommunicationFactory getFactory()
 * @method \FondOfImpala\Zed\PriceProductPriceListPageSearch\Persistence\PriceProductPriceListPageSearchQueryContainerInterface getQueryContainer()
 */
class PriceProductPriceListPageSearchEventSubscriber extends AbstractPlugin implements EventSubscriberInterface
{
    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return \Spryker\Zed\Event\Dependency\EventCollectionInterface
     */
    public function getSubscribedEvents(EventCollectionInterface $eventCollection): EventCollectionInterface
    {
        $eventCollection = $this->addAbstractPriceProductPriceListCreateListener($eventCollection);
        $eventCollection = $this->addAbstractPriceProductPriceListUpdateListener($eventCollection);
        $eventCollection = $this->addAbstractPriceProductPriceListDeleteListener($eventCollection);
        $eventCollection = $this->addAbstractPriceProductPriceListPublishListener($eventCollection);

        $eventCollection = $this->addConcretePriceProductPriceListCreateListener($eventCollection);
        $eventCollection = $this->addConcretePriceProductPriceListUpdateListener($eventCollection);
        $eventCollection = $this->addConcretePriceProductPriceListDeleteListener($eventCollection);

        return $this->addConcretePriceProductPriceListPublishListener($eventCollection);
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return \Spryker\Zed\Event\Dependency\EventCollectionInterface
     */
    protected function addConcretePriceProductPriceListCreateListener(
        EventCollectionInterface $eventCollection
    ): EventCollectionInterface {
        return $eventCollection->addListenerQueued(
            PriceProductPriceListEvents::ENTITY_FOS_PRICE_PRODUCT_PRICE_LIST_CREATE,
            new PriceProductPriceListConcreteListener(),
        );
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return \Spryker\Zed\Event\Dependency\EventCollectionInterface
     */
    protected function addConcretePriceProductPriceListUpdateListener(
        EventCollectionInterface $eventCollection
    ): EventCollectionInterface {
        return $eventCollection->addListenerQueued(
            PriceProductPriceListEvents::ENTITY_FOS_PRICE_PRODUCT_PRICE_LIST_UPDATE,
            new PriceProductPriceListConcreteListener(),
        );
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return \Spryker\Zed\Event\Dependency\EventCollectionInterface
     */
    protected function addConcretePriceProductPriceListDeleteListener(
        EventCollectionInterface $eventCollection
    ): EventCollectionInterface {
        return $eventCollection->addListenerQueued(
            PriceProductPriceListEvents::ENTITY_FOS_PRICE_PRODUCT_PRICE_LIST_DELETE,
            new PriceProductPriceListConcreteDeleteListener(),
        );
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return \Spryker\Zed\Event\Dependency\EventCollectionInterface
     */
    protected function addAbstractPriceProductPriceListCreateListener(
        EventCollectionInterface $eventCollection
    ): EventCollectionInterface {
        return $eventCollection->addListenerQueued(
            PriceProductPriceListEvents::ENTITY_FOS_PRICE_PRODUCT_PRICE_LIST_CREATE,
            new PriceProductPriceListAbstractListener(),
        );
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return \Spryker\Zed\Event\Dependency\EventCollectionInterface
     */
    protected function addAbstractPriceProductPriceListUpdateListener(
        EventCollectionInterface $eventCollection
    ): EventCollectionInterface {
        return $eventCollection->addListenerQueued(
            PriceProductPriceListEvents::ENTITY_FOS_PRICE_PRODUCT_PRICE_LIST_UPDATE,
            new PriceProductPriceListAbstractListener(),
        );
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return \Spryker\Zed\Event\Dependency\EventCollectionInterface
     */
    protected function addAbstractPriceProductPriceListDeleteListener(
        EventCollectionInterface $eventCollection
    ): EventCollectionInterface {
        return $eventCollection->addListenerQueued(
            PriceProductPriceListEvents::ENTITY_FOS_PRICE_PRODUCT_PRICE_LIST_DELETE,
            new PriceProductPriceListAbstractDeleteListener(),
        );
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return \Spryker\Zed\Event\Dependency\EventCollectionInterface
     */
    protected function addAbstractPriceProductPriceListPublishListener(
        EventCollectionInterface $eventCollection
    ): EventCollectionInterface {
        return $eventCollection->addListenerQueued(
            PriceProductPriceListEvents::PRICE_PRODUCT_ABSTRACT_PRICE_LIST_PUBLISH,
            new PriceProductPriceListAbstractListener(),
        );
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return \Spryker\Zed\Event\Dependency\EventCollectionInterface
     */
    protected function addConcretePriceProductPriceListPublishListener(
        EventCollectionInterface $eventCollection
    ): EventCollectionInterface {
        return $eventCollection->addListenerQueued(
            PriceProductPriceListEvents::PRICE_PRODUCT_CONCRETE_PRICE_LIST_PUBLISH,
            new PriceProductPriceListAbstractListener(),
        );
    }
}
