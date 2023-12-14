<?php

namespace FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade;

use Codeception\Test\Unit;
use Spryker\Shared\Kernel\Transfer\TransferInterface;
use Spryker\Zed\Event\Business\EventFacadeInterface;

class CompanyUserCompanyAssignerToEventFacadeBridgeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Event\Business\EventFacadeInterface
     */
    protected $eventFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Shared\Kernel\Transfer\TransferInterface
     */
    protected $transferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToEventFacadeBridge
     */
    protected $bridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->eventFacadeMock = $this->getMockBuilder(EventFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->transferMock = $this->getMockBuilder(TransferInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bridge = new CompanyUserCompanyAssignerToEventFacadeBridge($this->eventFacadeMock);
    }

    /**
     * @return void
     */
    public function testTrigger(): void
    {
        $eventName = 'foo';

        $this->eventFacadeMock->expects(static::atLeastOnce())
            ->method('trigger')
            ->with($eventName, $this->transferMock);

        $this->bridge->trigger($eventName, $this->transferMock);
    }
}
