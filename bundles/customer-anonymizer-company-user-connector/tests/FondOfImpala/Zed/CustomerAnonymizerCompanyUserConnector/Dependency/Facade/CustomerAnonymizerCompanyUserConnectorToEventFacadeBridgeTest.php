<?php

namespace FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Dependency\Facade;

use Codeception\Test\Unit;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Shared\Kernel\Transfer\TransferInterface;
use Spryker\Zed\Event\Business\EventFacadeInterface;

class CustomerAnonymizerCompanyUserConnectorToEventFacadeBridgeTest extends Unit
{
    /**
     * @var \Spryker\Zed\Event\Business\EventFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected EventFacadeInterface|MockObject $facadeMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUserTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected TransferInterface|MockObject $transferMock;

    /**
     * @var \FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Dependency\Facade\CustomerAnonymizerCompanyUserConnectorToEventFacadeBridge
     */
    protected CustomerAnonymizerCompanyUserConnectorToEventFacadeBridge $bridge;

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

        $this->bridge = new CustomerAnonymizerCompanyUserConnectorToEventFacadeBridge(
            $this->facadeMock,
        );
    }

    /**
     * @return void
     */
    public function testTrigger(): void
    {
        $this->facadeMock->expects(static::atLeastOnce())
            ->method('trigger');

        $this->bridge->trigger(
            'test',
            $this->transferMock,
        );
    }
}
