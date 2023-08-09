<?php

namespace FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Communication\Plugin\Event\Subscriber;

use FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Communication\Plugin\Event\Listener\ProductListPriceProductConcretePriceListPageSearchListener;
use Spryker\Zed\Event\Dependency\EventCollectionInterface;
use Spryker\Zed\Event\Dependency\Plugin\EventSubscriberInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\ProductList\Dependency\ProductListEvents;

/**
 * @method \FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Business\ProductListPriceProductPriceListPageSearchFacadeInterface getFacade()
 * @method \FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Communication\ProductListPriceProductPriceListPageSearchCommunicationFactory getFactory()
 */
class ProductListPriceProductConcretePriceListPageSearchSubscriber extends AbstractPlugin implements EventSubscriberInterface
{
    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return \Spryker\Zed\Event\Dependency\EventCollectionInterface
     */
    public function getSubscribedEvents(EventCollectionInterface $eventCollection): EventCollectionInterface
    {
        $this->addProductListPriceProductConcretePriceListPageSearchCreateListener($eventCollection);
        $this->addProductListPriceProductConcretePriceListPageSearchUpdateListener($eventCollection);
        $this->addProductListPriceProductConcretePriceListPageSearchDeleteListener($eventCollection);
        $this->addProductListPriceProductConcretePriceListPageSearchPublishListener($eventCollection);
        $this->addProductListPriceProductConcretePriceListPageSearchUnpublishListener($eventCollection);

        return $eventCollection;
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addProductListPriceProductConcretePriceListPageSearchCreateListener(
        EventCollectionInterface $eventCollection
    ): void {
        $eventCollection->addListenerQueued(
            ProductListEvents::ENTITY_SPY_PRODUCT_LIST_PRODUCT_CONCRETE_CREATE,
            new ProductListPriceProductConcretePriceListPageSearchListener(),
        );
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addProductListPriceProductConcretePriceListPageSearchUpdateListener(
        EventCollectionInterface $eventCollection
    ): void {
        $eventCollection->addListenerQueued(
            ProductListEvents::ENTITY_SPY_PRODUCT_LIST_PRODUCT_CONCRETE_UPDATE,
            new ProductListPriceProductConcretePriceListPageSearchListener(),
        );
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addProductListPriceProductConcretePriceListPageSearchDeleteListener(
        EventCollectionInterface $eventCollection
    ): void {
        $eventCollection->addListenerQueued(
            ProductListEvents::ENTITY_SPY_PRODUCT_LIST_PRODUCT_CONCRETE_DELETE,
            new ProductListPriceProductConcretePriceListPageSearchListener(),
        );
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addProductListPriceProductConcretePriceListPageSearchPublishListener(
        EventCollectionInterface $eventCollection
    ): void {
        $eventCollection->addListenerQueued(
            ProductListEvents::PRODUCT_LIST_PRODUCT_CONCRETE_PUBLISH,
            new ProductListPriceProductConcretePriceListPageSearchListener(),
        );
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addProductListPriceProductConcretePriceListPageSearchUnpublishListener(
        EventCollectionInterface $eventCollection
    ): void {
        $eventCollection->addListenerQueued(
            ProductListEvents::PRODUCT_LIST_PRODUCT_CONCRETE_UNPUBLISH,
            new ProductListPriceProductConcretePriceListPageSearchListener(),
        );
    }
}
