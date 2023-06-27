<?php

namespace FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Communication\Plugin\Event\Subscriber;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Communication\Plugin\Event\Listener\ProductListProductConcreteListener;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Event\Dependency\EventCollectionInterface;
use Spryker\Zed\ProductList\Dependency\ProductListEvents;

class ProductListConditionalAvailabilityPageSearchEventSubscriberTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Communication\Plugin\Event\Subscriber\ProductListConditionalAvailabilityPageSearchEventSubscriber
     */
    protected ProductListConditionalAvailabilityPageSearchEventSubscriber $subscriber;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Event\Dependency\EventCollectionInterface
     */
    protected MockObject|EventCollectionInterface $eventCollectionMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->eventCollectionMock = $this->getMockBuilder(EventCollectionInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->subscriber = new ProductListConditionalAvailabilityPageSearchEventSubscriber();
    }

    /**
     * @return void
     */
    public function testGetSubscribedEvents(): void
    {
        $this->eventCollectionMock->expects($this->atLeastOnce())
            ->method('addListenerQueued')
            ->withConsecutive(
                [ProductListEvents::ENTITY_SPY_PRODUCT_LIST_PRODUCT_CONCRETE_CREATE, new ProductListProductConcreteListener()],
                [ProductListEvents::ENTITY_SPY_PRODUCT_LIST_PRODUCT_CONCRETE_UPDATE, new ProductListProductConcreteListener()],
                [ProductListEvents::ENTITY_SPY_PRODUCT_LIST_PRODUCT_CONCRETE_DELETE, new ProductListProductConcreteListener()],
                [ProductListEvents::PRODUCT_LIST_PRODUCT_CONCRETE_PUBLISH, new ProductListProductConcreteListener()],
                [ProductListEvents::PRODUCT_LIST_PRODUCT_CONCRETE_UNPUBLISH, new ProductListProductConcreteListener()],
            )->willReturnSelf();

        static::assertEquals(
            $this->eventCollectionMock,
            $this->subscriber->getSubscribedEvents($this->eventCollectionMock),
        );
    }
}
