<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Communication\Plugin\Event\Subscriber;

use Codeception\Test\Unit;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Event\Dependency\EventCollection;
use Spryker\Zed\Event\Dependency\EventCollectionInterface;

class ConditionalAvailabilityPageSearchEventSubscriberTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Communication\Plugin\Event\Subscriber\ConditionalAvailabilityPageSearchEventSubscriber
     */
    protected ConditionalAvailabilityPageSearchEventSubscriber $subscriber;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Event\Dependency\EventCollectionInterface
     */
    protected MockObject|EventCollectionInterface $eventCollectionMock;

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
