<?php

namespace FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Communication\Plugin\Event\Subscriber;

use Codeception\Test\Unit;
use Exception;
use FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Communication\Plugin\Event\Listener\ProductListProductConcreteListener;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Event\Dependency\EventCollectionInterface;
use Spryker\Zed\Event\Dependency\Plugin\EventBaseHandlerInterface;
use Spryker\Zed\ProductList\Dependency\ProductListEvents;

class ProductListConditionalAvailabilityPageSearchEventSubscriberTest extends Unit
{
    protected ProductListConditionalAvailabilityPageSearchEventSubscriber $subscriber;

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
        $self = $this;

        $callCount = $this->atLeastOnce();
        $this->eventCollectionMock->expects($callCount)
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
                        $self->assertInstanceOf(ProductListProductConcreteListener::class, $eventHandler);

                        return $self->eventCollectionMock;
                    case 2:
                        $self->assertSame(ProductListEvents::ENTITY_SPY_PRODUCT_LIST_PRODUCT_CONCRETE_UPDATE, $eventName);
                        $self->assertInstanceOf(ProductListProductConcreteListener::class, $eventHandler);

                        return $self->eventCollectionMock;
                    case 3:
                        $self->assertSame(ProductListEvents::ENTITY_SPY_PRODUCT_LIST_PRODUCT_CONCRETE_DELETE, $eventName);
                        $self->assertInstanceOf(ProductListProductConcreteListener::class, $eventHandler);

                        return $self->eventCollectionMock;
                    case 4:
                        $self->assertSame(ProductListEvents::PRODUCT_LIST_PRODUCT_CONCRETE_PUBLISH, $eventName);
                        $self->assertInstanceOf(ProductListProductConcreteListener::class, $eventHandler);

                        return $self->eventCollectionMock;
                    case 5:
                        $self->assertSame(ProductListEvents::PRODUCT_LIST_PRODUCT_CONCRETE_UNPUBLISH, $eventName);
                        $self->assertInstanceOf(ProductListProductConcreteListener::class, $eventHandler);

                        return $self->eventCollectionMock;
                }

                throw new Exception('Unexpected call count');
            });

        static::assertEquals(
            $this->eventCollectionMock,
            $this->subscriber->getSubscribedEvents($this->eventCollectionMock),
        );
    }
}
