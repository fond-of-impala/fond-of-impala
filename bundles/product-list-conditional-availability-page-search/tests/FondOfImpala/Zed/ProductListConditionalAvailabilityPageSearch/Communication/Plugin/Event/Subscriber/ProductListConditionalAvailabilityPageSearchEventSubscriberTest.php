<?php

namespace FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Communication\Plugin\Event\Subscriber;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Communication\Plugin\Event\Listener\ProductListProductConcreteListener;
use Spryker\Zed\Event\Dependency\EventCollectionInterface;
use Spryker\Zed\ProductList\Dependency\ProductListEvents;

class ProductListConditionalAvailabilityPageSearchEventSubscriberTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Communication\Plugin\Event\Subscriber\ProductListConditionalAvailabilityPageSearchEventSubscriber
     */
    protected $productListConditionalAvailabilityPageSearchEventSubscriber;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Event\Dependency\EventCollectionInterface
     */
    protected $eventCollectionInterfaceMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->eventCollectionInterfaceMock = $this->getMockBuilder(EventCollectionInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productListConditionalAvailabilityPageSearchEventSubscriber = new ProductListConditionalAvailabilityPageSearchEventSubscriber();
    }

    /**
     * @return void
     */
    public function testGetSubscribedEvents(): void
    {
        $this->eventCollectionInterfaceMock->expects($this->atLeastOnce())
            ->method('addListenerQueued')
            ->withConsecutive(
                [ProductListEvents::ENTITY_SPY_PRODUCT_LIST_PRODUCT_CONCRETE_CREATE, new ProductListProductConcreteListener()],
                [ProductListEvents::ENTITY_SPY_PRODUCT_LIST_PRODUCT_CONCRETE_UPDATE, new ProductListProductConcreteListener()],
                [ProductListEvents::ENTITY_SPY_PRODUCT_LIST_PRODUCT_CONCRETE_DELETE, new ProductListProductConcreteListener()],
                [ProductListEvents::PRODUCT_LIST_PRODUCT_CONCRETE_PUBLISH, new ProductListProductConcreteListener()],
                [ProductListEvents::PRODUCT_LIST_PRODUCT_CONCRETE_UNPUBLISH, new ProductListProductConcreteListener()],
            )->willReturnSelf();

        $this->assertInstanceOf(
            EventCollectionInterface::class,
            $this->productListConditionalAvailabilityPageSearchEventSubscriber->getSubscribedEvents(
                $this->eventCollectionInterfaceMock,
            ),
        );
    }
}
