<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Dependency\Facade;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CustomerTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Customer\Business\CustomerFacadeInterface;

class ConditionalAvailabilityCheckoutConnectorToCustomerFacadeBridgeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|(\Spryker\Zed\Customer\Business\CustomerFacadeInterface&\PHPUnit\Framework\MockObject\MockObject)
     */
    protected MockObject|CustomerFacadeInterface $facadeMock;

    /**
     * @var (\Generated\Shared\Transfer\CustomerTransfer&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CustomerTransfer|MockObject $customerTransferMock;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Dependency\Facade\ConditionalAvailabilityCheckoutConnectorToCustomerFacadeBridge
     */
    protected ConditionalAvailabilityCheckoutConnectorToCustomerFacadeBridge $bridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->facadeMock = $this->getMockBuilder(CustomerFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerTransferMock = $this->getMockBuilder(CustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bridge = new ConditionalAvailabilityCheckoutConnectorToCustomerFacadeBridge(
            $this->facadeMock,
        );
    }

    /**
     * @return void
     */
    public function testFindGroupedConditionalAvailabilities(): void
    {
        $this->facadeMock->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->with($this->customerTransferMock)
            ->willReturn($this->customerTransferMock);

        static::assertEquals(
            $this->customerTransferMock,
            $this->bridge->getCustomer(
                $this->customerTransferMock,
            ),
        );
    }
}
