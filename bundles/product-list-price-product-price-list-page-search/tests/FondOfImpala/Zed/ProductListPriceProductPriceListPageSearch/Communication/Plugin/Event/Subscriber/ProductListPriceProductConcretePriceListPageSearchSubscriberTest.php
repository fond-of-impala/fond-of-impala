<?php

namespace FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Communication\Plugin\Event\Subscriber;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Communication\Plugin\Event\Listener\ProductListPriceProductConcretePriceListPageSearchListener;
use Spryker\Zed\Event\Dependency\EventCollectionInterface;
use Spryker\Zed\ProductList\Dependency\ProductListEvents;

class ProductListPriceProductConcretePriceListPageSearchSubscriberTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Event\Dependency\EventCollectionInterface
     */
    protected $eventCollectionInterfaceMock;

    /**
     * @var \FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Communication\Plugin\Event\Subscriber\ProductListPriceProductConcretePriceListPageSearchSubscriber
     */
    protected $productListPriceProductConcretePriceListPageSearchSubscriber;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->eventCollectionInterfaceMock = $this->getMockBuilder(EventCollectionInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productListPriceProductConcretePriceListPageSearchSubscriber = new ProductListPriceProductConcretePriceListPageSearchSubscriber();
    }

    /**
     * @return void
     */
    public function testGetSubscribedEvents(): void
    {
        $this->eventCollectionInterfaceMock->expects(self::atLeastOnce())
            ->method('addListenerQueued')
            ->withConsecutive(
                [ProductListEvents::ENTITY_SPY_PRODUCT_LIST_PRODUCT_CONCRETE_CREATE, new ProductListPriceProductConcretePriceListPageSearchListener()],
                [ProductListEvents::ENTITY_SPY_PRODUCT_LIST_PRODUCT_CONCRETE_UPDATE, new ProductListPriceProductConcretePriceListPageSearchListener()],
                [ProductListEvents::ENTITY_SPY_PRODUCT_LIST_PRODUCT_CONCRETE_DELETE, new ProductListPriceProductConcretePriceListPageSearchListener()],
                [ProductListEvents::PRODUCT_LIST_PRODUCT_CONCRETE_PUBLISH, new ProductListPriceProductConcretePriceListPageSearchListener()],
                [ProductListEvents::PRODUCT_LIST_PRODUCT_CONCRETE_UNPUBLISH, new ProductListPriceProductConcretePriceListPageSearchListener()],
            )->willReturnSelf();

        self::assertEquals(
            $this->eventCollectionInterfaceMock,
            $this->productListPriceProductConcretePriceListPageSearchSubscriber->getSubscribedEvents(
                $this->eventCollectionInterfaceMock,
            ),
        );
    }
}
