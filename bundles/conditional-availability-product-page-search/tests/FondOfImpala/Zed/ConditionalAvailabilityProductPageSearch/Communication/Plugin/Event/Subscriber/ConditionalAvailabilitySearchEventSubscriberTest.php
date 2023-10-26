<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Communication\Plugin\Event\Subscriber;

use Codeception\Test\Unit;
use Exception;
use FondOfImpala\Zed\ConditionalAvailability\Dependency\ConditionalAvailabilityEvents;
use FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Communication\Plugin\Event\Listener\ConditionalAvailabilityProductPageSearchPublishListener;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Event\Dependency\EventCollectionInterface;
use Spryker\Zed\Event\Dependency\Plugin\EventBaseHandlerInterface;

class ConditionalAvailabilitySearchEventSubscriberTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Event\Dependency\EventCollectionInterface
     */
    protected MockObject|EventCollectionInterface $eventCollectionMock;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityProductPageSearch\Communication\Plugin\Event\Subscriber\ConditionalAvailabilityProductPageSearchEventSubscriber
     */
    protected ConditionalAvailabilityProductPageSearchEventSubscriber $subscriber;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->eventCollectionMock = $this->getMockBuilder(EventCollectionInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->subscriber = new ConditionalAvailabilityProductPageSearchEventSubscriber();
    }

    /**
     * @return void
     */
    public function testGetSubscribedEvents(): void
    {
        $this->eventCollectionMock
            ->expects(static::exactly(1))
            ->method('addListenerQueued')
            ->willReturnCallback(static function (string $eventName, EventBaseHandlerInterface $eventHandler) {
                if ($eventName === ConditionalAvailabilityEvents::ENTITY_FOI_CONDITIONAL_AVAILABILITY_PERIOD_CREATE) {
                    static::assertInstanceOf(ConditionalAvailabilityProductPageSearchPublishListener::class, $eventHandler);

                    return;
                }

                throw new Exception('fail');
            });

        $eventCollectionMock = $this->subscriber->getSubscribedEvents($this->eventCollectionMock);

        static::assertEquals($this->eventCollectionMock, $eventCollectionMock);
    }
}
