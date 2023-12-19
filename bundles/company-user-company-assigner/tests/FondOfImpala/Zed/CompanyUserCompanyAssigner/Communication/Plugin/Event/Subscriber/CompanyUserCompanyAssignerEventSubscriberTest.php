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
        $this->eventCollectionMock->expects(static::atLeastOnce())
            ->method('addListenerQueued')
            ->withConsecutive(
                [
                    CompanyUserCompanyAssignerEvents::MANUFACTURER_USER_MARK_FOR_ASSIGMENT,
                    static::callback(
                        static function (EventBaseHandlerInterface $eventBaseHandler) {
                            return $eventBaseHandler instanceof AssignManufacturerUserToNonManufacturerCompaniesListener;
                        },
                    ),
                    0,
                    null,
                    null,
                ],
                [
                    CompanyUserCompanyAssignerEvents::MANUFACTURER_COMPANY_USER_COMPANY_ROLE_UPDATE,
                    static::callback(
                        static function (EventBaseHandlerInterface $eventBaseHandler) {
                            return $eventBaseHandler instanceof UpdateNonManufacturerUsersCompanyRole;
                        },
                    ),
                    0,
                    null,
                    null,
                ],
            )->willReturn($this->eventCollectionMock);

        static::assertEquals(
            $this->eventCollectionMock,
            $this->subscriber->getSubscribedEvents($this->eventCollectionMock),
        );
    }
}
