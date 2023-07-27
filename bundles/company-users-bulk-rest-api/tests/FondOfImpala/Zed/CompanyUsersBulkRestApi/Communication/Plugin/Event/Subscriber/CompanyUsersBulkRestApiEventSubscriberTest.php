<?php

namespace FondOfImpala\Zed\CompanyUsersBulkRestApi\Communication\Plugin\Event\Subscriber;

use Codeception\Test\Unit;
use Exception;
use FondOfImpala\Shared\CompanyUsersBulkRestApi\CompanyUsersBulkRestApiConstants;
use FondOfImpala\Zed\CompanyUsersBulkRestApi\Communication\Plugin\Event\Listener\CompanyUsersBulkRestApiCompanyUserCreatorListener;
use FondOfImpala\Zed\CompanyUsersBulkRestApi\Communication\Plugin\Event\Listener\CompanyUsersBulkRestApiCompanyUserDeleterListener;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Event\Dependency\EventCollectionInterface;
use Spryker\Zed\Event\Dependency\Plugin\EventBaseHandlerInterface;

class CompanyUsersBulkRestApiEventSubscriberTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyUsersBulkRestApi\Communication\Plugin\Event\Subscriber\CompanyUsersBulkRestApiEventSubscriber
     */
    protected CompanyUsersBulkRestApiEventSubscriber $subscriber;

    /**
     * @var \Spryker\Zed\Event\Dependency\EventCollectionInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected EventCollectionInterface|MockObject $eventCollectionMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->eventCollectionMock = $this->getMockBuilder(EventCollectionInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->subscriber = new CompanyUsersBulkRestApiEventSubscriber();
    }

    /**
     * @return void
     */
    public function testGetSubscribedEvents(): void
    {
        $this->eventCollectionMock
            ->expects(static::exactly(2))
            ->method('addListenerQueued')
            ->willReturnCallback(static function (string $eventName, EventBaseHandlerInterface $eventHandler) {
                if ($eventName === CompanyUsersBulkRestApiConstants::BULK_ASSIGN) {
                    static::assertInstanceOf(CompanyUsersBulkRestApiCompanyUserCreatorListener::class, $eventHandler);

                    return;
                }
                if ($eventName === CompanyUsersBulkRestApiConstants::BULK_UNASSIGN) {
                    static::assertInstanceOf(CompanyUsersBulkRestApiCompanyUserDeleterListener::class, $eventHandler);

                    return;
                }

                throw new Exception('fail');
            });

        $this->subscriber->getSubscribedEvents($this->eventCollectionMock);
    }
}
