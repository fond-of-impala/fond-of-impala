<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Communication\Plugin\Event\Subscriber;

use Codeception\Test\Unit;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Event\Dependency\EventCollection;
use Spryker\Zed\Event\Dependency\EventCollectionInterface;

class ConditionalAvailabilityPageSearchEventSubscriberTest extends Unit
{
    protected MockObject|EventCollectionInterface $eventCollectionMock;

    protected ConditionalAvailabilityPageSearchEventSubscriber $subscriber;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->eventCollectionMock = $this->getMockBuilder(EventCollection::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->subscriber = new ConditionalAvailabilityPageSearchEventSubscriber();
    }

    /**
     * @return void
     */
    public function testGetSubscribedEvents(): void
    {
        static::assertInstanceOf(
            EventCollection::class,
            $this->subscriber->getSubscribedEvents($this->eventCollectionMock),
        );
    }
}
