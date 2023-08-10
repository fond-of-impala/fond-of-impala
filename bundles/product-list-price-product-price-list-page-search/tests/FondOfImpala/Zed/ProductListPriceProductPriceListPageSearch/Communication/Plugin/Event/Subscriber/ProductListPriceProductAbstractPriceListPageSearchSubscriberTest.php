<?php

namespace FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Communication\Plugin\Event\Subscriber;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Communication\Plugin\Event\Listener\ProductListPriceProductAbstractPriceListPageSearchListener;
use Spryker\Zed\Event\Dependency\EventCollectionInterface;
use Spryker\Zed\ProductList\Dependency\ProductListEvents;

class ProductListPriceProductAbstractPriceListPageSearchSubscriberTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Event\Dependency\EventCollectionInterface
     */
    protected $eventCollectionInterfaceMock;

    /**
     * @var \FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Communication\Plugin\Event\Subscriber\ProductListPriceProductAbstractPriceListPageSearchSubscriber
     */
    protected $productListPriceProductAbstractPriceListPageSearchSubscriber;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->eventCollectionInterfaceMock = $this->getMockBuilder(EventCollectionInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productListPriceProductAbstractPriceListPageSearchSubscriber = new ProductListPriceProductAbstractPriceListPageSearchSubscriber();
    }

    /**
     * @return void
     */
    public function testGetSubscribedEvents(): void
    {
        $this->eventCollectionInterfaceMock->expects(self::atLeastOnce())
            ->method('addListenerQueued')
            ->withConsecutive(
                [ProductListEvents::ENTITY_SPY_PRODUCT_LIST_PRODUCT_CONCRETE_CREATE, new ProductListPriceProductAbstractPriceListPageSearchListener()],
                [ProductListEvents::ENTITY_SPY_PRODUCT_LIST_PRODUCT_CONCRETE_UPDATE, new ProductListPriceProductAbstractPriceListPageSearchListener()],
                [ProductListEvents::ENTITY_SPY_PRODUCT_LIST_PRODUCT_CONCRETE_DELETE, new ProductListPriceProductAbstractPriceListPageSearchListener()],
                [ProductListEvents::PRODUCT_LIST_PRODUCT_CONCRETE_PUBLISH, new ProductListPriceProductAbstractPriceListPageSearchListener()],
                [ProductListEvents::PRODUCT_LIST_PRODUCT_CONCRETE_UNPUBLISH, new ProductListPriceProductAbstractPriceListPageSearchListener()],
            )->willReturnSelf();

        self::assertEquals(
            $this->eventCollectionInterfaceMock,
            $this->productListPriceProductAbstractPriceListPageSearchSubscriber->getSubscribedEvents(
                $this->eventCollectionInterfaceMock,
            ),
        );
    }
}
