<?php

namespace FondOfImpala\Zed\CompanyUserCompanyAssigner\Communication\Plugin\Event\Subscriber;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Communication\Plugin\Event\Listener\AssignManufacturerUserToNonManufacturerCompaniesListener;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Communication\Plugin\Event\Listener\UpdateNonManufacturerUsersCompanyRole;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\CompanyUserCompanyAssignerEvents;
use Spryker\Zed\Event\Dependency\EventCollectionInterface;
use Spryker\Zed\Event\Dependency\Plugin\EventBaseHandlerInterface;

class CompanyUserCompanyAssignerEventSubscriberTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Event\Dependency\EventCollectionInterface&\PHPUnit\Framework\MockObject\MockObject
     */
    protected $eventCollectionMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCompanyAssigner\Communication\Plugin\Event\Subscriber\CompanyUserCompanyAssignerEventSubscriber
     */
    protected $subscriber;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->eventCollectionMock = $this->getMockBuilder(EventCollectionInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->subscriber = new CompanyUserCompanyAssignerEventSubscriber();
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
                        $self->assertSame(CompanyUserCompanyAssignerEvents::MANUFACTURER_USER_MARK_FOR_ASSIGMENT, $eventName);
                        $self->assertInstanceOf(AssignManufacturerUserToNonManufacturerCompaniesListener::class, $eventHandler);
                        $self->assertEquals(0, $priority);
                        $self->assertNull($queuePoolName);
                        $self->assertNull($eventQueueName);

                        return $self->eventCollectionMock;
                    case 2:
                        $self->assertSame(CompanyUserCompanyAssignerEvents::MANUFACTURER_COMPANY_USER_COMPANY_ROLE_UPDATE, $eventName);
                        $self->assertInstanceOf(UpdateNonManufacturerUsersCompanyRole::class, $eventHandler);
                        $self->assertEquals(0, $priority);
                        $self->assertNull($queuePoolName);
                        $self->assertNull($eventQueueName);

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
