<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Communication\Plugin\Event\Subscriber;

use Codeception\Test\Unit;
use Spryker\Zed\Event\Dependency\EventCollectionInterface;

class ConditionalAvailabilityPageSearchEventSubscriberTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Communication\Plugin\Event\Subscriber\ConditionalAvailabilityPageSearchEventSubscriber
     */
    protected $conditionalAvailabilityPageSearchEventSubscriber;

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

        $this->conditionalAvailabilityPageSearchEventSubscriber = new ConditionalAvailabilityPageSearchEventSubscriber();
    }

    /**
     * @return void
     */
    public function testGetSubscribedEvents(): void
    {
        $this->assertInstanceOf(
            EventCollectionInterface::class,
            $this->conditionalAvailabilityPageSearchEventSubscriber->getSubscribedEvents(
                $this->eventCollectionInterfaceMock,
            ),
        );
    }
}
