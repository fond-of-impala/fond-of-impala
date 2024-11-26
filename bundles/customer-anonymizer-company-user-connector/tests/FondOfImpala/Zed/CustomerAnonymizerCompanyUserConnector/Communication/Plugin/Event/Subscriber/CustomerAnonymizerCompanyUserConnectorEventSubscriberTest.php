<?php

namespace FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Communication\Plugin\Event\Subscriber;

use Codeception\Test\Unit;
use Exception;
use FondOfImpala\Shared\CustomerAnonymizerCompanyUserConnector\CustomerAnonymizerCompanyUserConnectorConstants;
use FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Communication\Plugin\Event\Listener\CompanyUserDeleterListener;
use Spryker\Zed\Event\Dependency\EventCollectionInterface;
use Spryker\Zed\Event\Dependency\Plugin\EventBaseHandlerInterface;

class CustomerAnonymizerCompanyUserConnectorEventSubscriberTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Event\Dependency\EventCollectionInterface
     */
    protected $eventCollectionMock;

    /**
     * @var \FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Communication\Plugin\Event\Subscriber\CustomerAnonymizerCompanyUserConnectorEventSubscriber
     */
    protected $eventSubscriber;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->eventCollectionMock = $this->getMockBuilder(EventCollectionInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->eventSubscriber = new CustomerAnonymizerCompanyUserConnectorEventSubscriber();
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
                        $self->assertSame(CustomerAnonymizerCompanyUserConnectorConstants::EVENT_DELETE_COMPANY_USER, $eventName);
                        $self->assertInstanceOf(CompanyUserDeleterListener::class, $eventHandler);
                        $self->assertSame(0, $priority);
                        $self->assertNull($queuePoolName);
                        $self->assertNull($eventQueueName);

                        return $self->eventCollectionMock;
                }

                throw new Exception('Unexpected call count');
            });

        static::assertEquals(
            $this->eventCollectionMock,
            $this->eventSubscriber->getSubscribedEvents(
                $this->eventCollectionMock,
            ),
        );
    }
}
