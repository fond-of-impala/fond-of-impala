<?php

namespace FondOfImpala\Zed\OrderBudgetsBulkRestApi\Communication\Plugin\Event\Subscriber;

use Codeception\Test\Unit;
use FondOfImpala\Zed\OrderBudgetsBulkRestApi\Communication\Plugin\Event\Listener\OrderBudgetPersistProcessListener;
use FondOfImpala\Zed\OrderBudgetsBulkRestApi\Dependency\OrderBudgetsBulkRestApiEvents;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Event\Dependency\EventCollectionInterface;
use Spryker\Zed\Event\Dependency\Plugin\EventBaseHandlerInterface;

class OrderBudgetsBulkRestApiEventSubscriberTest extends Unit
{
    protected EventCollectionInterface|MockObject $eventCollectionMock;

    protected OrderBudgetsBulkRestApiEventSubscriber $subscriber;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->eventCollectionMock = $this->getMockBuilder(EventCollectionInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->subscriber = new OrderBudgetsBulkRestApiEventSubscriber();
    }

    /**
     * @return void
     */
    public function testGetSubscribedEvents(): void
    {
        $this->eventCollectionMock->expects(static::atLeastOnce())
            ->method('addListenerQueued')
            ->with(
                OrderBudgetsBulkRestApiEvents::PERSIST_PROCESS,
                static::callback(
                    static fn (
                        EventBaseHandlerInterface $eventBaseHandler
                    ): bool => $eventBaseHandler instanceof OrderBudgetPersistProcessListener,
                ),
            )->willReturn($this->eventCollectionMock);

        static::assertEquals(
            $this->eventCollectionMock,
            $this->subscriber->getSubscribedEvents($this->eventCollectionMock),
        );
    }
}
