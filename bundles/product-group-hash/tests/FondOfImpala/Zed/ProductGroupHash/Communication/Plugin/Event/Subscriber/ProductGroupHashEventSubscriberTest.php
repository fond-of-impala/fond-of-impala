<?php

namespace FondOfImpala\Zed\ProductGroupHash\Communication\Plugin\Event\Subscriber;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ProductGroupHash\Communication\Plugin\Event\Listener\ProductGroupHashListener;
use LogicException;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Event\Dependency\EventCollectionInterface;
use Spryker\Zed\Event\Dependency\Plugin\EventBaseHandlerInterface;
use Spryker\Zed\Product\Dependency\ProductEvents;

class ProductGroupHashEventSubscriberTest extends Unit
{
    protected EventCollectionInterface|MockObject $eventCollectionMock;

    protected ProductGroupHashEventSubscriber $subscriber;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->eventCollectionMock = $this->getMockBuilder(EventCollectionInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->subscriber = new ProductGroupHashEventSubscriber();
    }

    /**
     * @return void
     */
    public function testGetSubscribedEvents(): void
    {
        $this->eventCollectionMock->expects(static::atLeastOnce())
            ->method('addListener')
            ->willReturnCallback(
                fn (
                    string $eventName,
                    EventBaseHandlerInterface $eventHandler,
                    ?int $priority = 0,
                    ?string $queuePoolName = null,
                    ?string $eventQueueName = null
                ): LogicException|EventCollectionInterface => match (
                    [
                    $eventName,
                    get_class($eventHandler),
                    $priority,
                    $queuePoolName,
                    $eventQueueName,
                    ]
                ) {
                    [
                        ProductEvents::PRODUCT_ABSTRACT_BEFORE_CREATE,
                        ProductGroupHashListener::class,
                        0,
                        null,
                        null,
                    ] => $this->eventCollectionMock, [
                        ProductEvents::PRODUCT_ABSTRACT_BEFORE_UPDATE,
                        ProductGroupHashListener::class,
                        0,
                        null,
                        null,
                    ] => $this->eventCollectionMock,
                    default => new LogicException('Unsupported parameters.')
                },
            );

        static::assertEquals(
            $this->eventCollectionMock,
            $this->subscriber->getSubscribedEvents($this->eventCollectionMock),
        );
    }
}
