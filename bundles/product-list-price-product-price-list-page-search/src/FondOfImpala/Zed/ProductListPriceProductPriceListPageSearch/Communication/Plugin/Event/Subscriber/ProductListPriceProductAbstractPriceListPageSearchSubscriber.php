<?php

namespace FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Communication\Plugin\Event\Subscriber;

use FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Communication\Plugin\Event\Listener\ProductListPriceProductAbstractPriceListPageSearchListener;
use Spryker\Zed\Event\Dependency\EventCollectionInterface;
use Spryker\Zed\Event\Dependency\Plugin\EventSubscriberInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\ProductList\Dependency\ProductListEvents;

/**
 * @method \FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Business\ProductListPriceProductPriceListPageSearchFacadeInterface getFacade()
 * @method \FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Communication\ProductListPriceProductPriceListPageSearchCommunicationFactory getFactory()
 */
class ProductListPriceProductAbstractPriceListPageSearchSubscriber extends AbstractPlugin implements EventSubscriberInterface
{
    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return \Spryker\Zed\Event\Dependency\EventCollectionInterface
     */
    public function getSubscribedEvents(EventCollectionInterface $eventCollection): EventCollectionInterface
    {
        $this->addProductListPriceProductAbstractPriceListPageSearchCreateListener($eventCollection);
        $this->addProductListPriceProductAbstractPriceListPageSearchUpdateListener($eventCollection);
        $this->addProductListPriceProductAbstractPriceListPageSearchDeleteListener($eventCollection);
        $this->addProductListPriceProductAbstractPriceListPageSearchPublishListener($eventCollection);
        $this->addProductListPriceProductAbstractPriceListPageSearchUnpublishListener($eventCollection);

        return $eventCollection;
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addProductListPriceProductAbstractPriceListPageSearchCreateListener(
        EventCollectionInterface $eventCollection
    ): void {
        $eventCollection->addListenerQueued(
            ProductListEvents::ENTITY_SPY_PRODUCT_LIST_PRODUCT_CONCRETE_CREATE,
            new ProductListPriceProductAbstractPriceListPageSearchListener(),
        );
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addProductListPriceProductAbstractPriceListPageSearchUpdateListener(
        EventCollectionInterface $eventCollection
    ): void {
        $eventCollection->addListenerQueued(
            ProductListEvents::ENTITY_SPY_PRODUCT_LIST_PRODUCT_CONCRETE_UPDATE,
            new ProductListPriceProductAbstractPriceListPageSearchListener(),
        );
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addProductListPriceProductAbstractPriceListPageSearchDeleteListener(
        EventCollectionInterface $eventCollection
    ): void {
        $eventCollection->addListenerQueued(
            ProductListEvents::ENTITY_SPY_PRODUCT_LIST_PRODUCT_CONCRETE_DELETE,
            new ProductListPriceProductAbstractPriceListPageSearchListener(),
        );
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addProductListPriceProductAbstractPriceListPageSearchPublishListener(
        EventCollectionInterface $eventCollection
    ): void {
        $eventCollection->addListenerQueued(
            ProductListEvents::PRODUCT_LIST_PRODUCT_CONCRETE_PUBLISH,
            new ProductListPriceProductAbstractPriceListPageSearchListener(),
        );
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addProductListPriceProductAbstractPriceListPageSearchUnpublishListener(
        EventCollectionInterface $eventCollection
    ): void {
        $eventCollection->addListenerQueued(
            ProductListEvents::PRODUCT_LIST_PRODUCT_CONCRETE_UNPUBLISH,
            new ProductListPriceProductAbstractPriceListPageSearchListener(),
        );
    }
}
