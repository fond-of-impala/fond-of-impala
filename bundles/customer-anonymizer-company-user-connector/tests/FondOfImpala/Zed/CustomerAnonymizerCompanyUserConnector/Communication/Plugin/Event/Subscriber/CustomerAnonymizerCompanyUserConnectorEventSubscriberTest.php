<?php

namespace FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Communication\Plugin\Event\Subscriber;

use Codeception\Test\Unit;
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
        $this->eventCollectionMock->expects(static::atLeastOnce())
            ->method('addListenerQueued')
            ->withConsecutive(
                [
                    CustomerAnonymizerCompanyUserConnectorConstants::EVENT_DELETE_COMPANY_USER,
                    static::callback(
                        static fn (EventBaseHandlerInterface $eventHandler): bool => $eventHandler instanceof CompanyUserDeleterListener,
                    ),
                    0,
                    null,
                    null,
                ],
            );

        static::assertEquals(
            $this->eventCollectionMock,
            $this->eventSubscriber->getSubscribedEvents(
                $this->eventCollectionMock,
            ),
        );
    }
}
