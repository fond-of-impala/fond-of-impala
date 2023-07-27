<?php

namespace FondOfImpala\Zed\CompanyUsersBulkRestApi\Dependency\Facade;

use Codeception\Test\Unit;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Shared\Kernel\Transfer\TransferInterface;
use Spryker\Zed\Event\Business\EventFacadeInterface;

class CompanyUsersBulkRestApiToEventFacadeBridgeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyUsersBulkRestApi\Dependency\Facade\CompanyUsersBulkRestApiToEventFacadeBridge
     */
    protected CompanyUsersBulkRestApiToEventFacadeBridge $facadeBridge;

    /**
     * @var \Spryker\Zed\Event\Business\EventFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected EventFacadeInterface|MockObject $facadeMock;

    /**
     * @var \Spryker\Shared\Kernel\Transfer\TransferInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected TransferInterface|MockObject $transferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->facadeMock = $this->getMockBuilder(EventFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->transferMock = $this->getMockBuilder(TransferInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->facadeBridge = new CompanyUsersBulkRestApiToEventFacadeBridge(
            $this->facadeMock,
        );
    }

    /**
     * @return void
     */
    public function testTrigger(): void
    {
        $this->facadeMock
            ->expects(static::atLeastOnce())
            ->method('trigger');

        $this->facadeBridge->trigger('event', $this->transferMock);
    }
}
