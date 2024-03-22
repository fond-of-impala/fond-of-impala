<?php

namespace FondOfImpala\Zed\ProductGroupHash\Communication\Plugin\Event\Subscriber;

use FondOfImpala\Zed\ProductGroupHash\Communication\Plugin\Event\Listener\ProductGroupHashListener;
use Spryker\Zed\Event\Dependency\EventCollectionInterface;
use Spryker\Zed\Event\Dependency\Plugin\EventSubscriberInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\Product\Dependency\ProductEvents;

class ProductGroupHashEventSubscriber extends AbstractPlugin implements EventSubscriberInterface
{
    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return \Spryker\Zed\Event\Dependency\EventCollectionInterface
     */
    public function getSubscribedEvents(EventCollectionInterface $eventCollection)
    {
        $eventCollection = $eventCollection->addListener(
            ProductEvents::PRODUCT_ABSTRACT_BEFORE_CREATE,
            new ProductGroupHashListener(),
        );

        return $eventCollection->addListener(
            ProductEvents::PRODUCT_ABSTRACT_BEFORE_CREATE,
            new ProductGroupHashListener(),
        );
    }
}
