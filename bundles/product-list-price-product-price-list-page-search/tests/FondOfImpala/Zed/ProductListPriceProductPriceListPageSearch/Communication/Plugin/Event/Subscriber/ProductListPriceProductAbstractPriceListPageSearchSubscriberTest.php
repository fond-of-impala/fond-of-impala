<?php

namespace FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Communication\Plugin\Event\Subscriber;

use Codeception\Test\Unit;
use Exception;
use FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Communication\Plugin\Event\Listener\ProductListPriceProductAbstractPriceListPageSearchListener;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Event\Dependency\EventCollectionInterface;
use Spryker\Zed\Event\Dependency\Plugin\EventBaseHandlerInterface;
use Spryker\Zed\ProductList\Dependency\ProductListEvents;

class ProductListPriceProductAbstractPriceListPageSearchSubscriberTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Event\Dependency\EventCollectionInterface
     */
    protected MockObject|EventCollectionInterface $eventCollectionInterfaceMock;

    /**
     * @var \FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Communication\Plugin\Event\Subscriber\ProductListPriceProductAbstractPriceListPageSearchSubscriber
     */
    protected ProductListPriceProductAbstractPriceListPageSearchSubscriber $productListPriceProductAbstractPriceListPageSearchSubscriber;

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
        $self = $this;
        $callCount = $this->atLeastOnce();
        $this->eventCollectionInterfaceMock->expects($callCount)
            ->method('addListenerQueued')
            ->willReturnCallback(static function ($eventName, EventBaseHandlerInterface $eventHandler, $priority = 0, $queuePoolName = null, $eventQueueName = null) use ($self, $callCount) {
                /** @phpstan-ignore-next-line */
                if (method_exists($callCount, 'getInvocationCount')) {
                    /** @phpstan-ignore-next-line */
                    $count = $callCount->getInvocationCount();
                } else {
                    /** @phpstan-ignore-next-line */
                    $count = $callCount->numberOfInvocations();
                }

                switch ($count) {
                    case 1:
                        $self->assertSame(ProductListEvents::ENTITY_SPY_PRODUCT_LIST_PRODUCT_CONCRETE_CREATE, $eventName);
                        $self->assertInstanceOf(ProductListPriceProductAbstractPriceListPageSearchListener::class, $eventHandler);

                        return $self->eventCollectionInterfaceMock;
                    case 2:
                        $self->assertSame(ProductListEvents::ENTITY_SPY_PRODUCT_LIST_PRODUCT_CONCRETE_UPDATE, $eventName);
                        $self->assertInstanceOf(ProductListPriceProductAbstractPriceListPageSearchListener::class, $eventHandler);

                        return $self->eventCollectionInterfaceMock;
                    case 3:
                        $self->assertSame(ProductListEvents::ENTITY_SPY_PRODUCT_LIST_PRODUCT_CONCRETE_DELETE, $eventName);
                        $self->assertInstanceOf(ProductListPriceProductAbstractPriceListPageSearchListener::class, $eventHandler);

                        return $self->eventCollectionInterfaceMock;
                    case 4:
                        $self->assertSame(ProductListEvents::PRODUCT_LIST_PRODUCT_CONCRETE_PUBLISH, $eventName);
                        $self->assertInstanceOf(ProductListPriceProductAbstractPriceListPageSearchListener::class, $eventHandler);

                        return $self->eventCollectionInterfaceMock;
                    case 5:
                        $self->assertSame(ProductListEvents::PRODUCT_LIST_PRODUCT_CONCRETE_UNPUBLISH, $eventName);
                        $self->assertInstanceOf(ProductListPriceProductAbstractPriceListPageSearchListener::class, $eventHandler);

                        return $self->eventCollectionInterfaceMock;
                }

                throw new Exception('Unexpected call count');
            });

        self::assertEquals(
            $this->eventCollectionInterfaceMock,
            $this->productListPriceProductAbstractPriceListPageSearchSubscriber->getSubscribedEvents(
                $this->eventCollectionInterfaceMock,
            ),
        );
    }
}
