<?php

namespace FondOfImpala\Client\ConditionalAvailabilityPageSearch\Dependency\Client;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CustomerTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Client\Customer\CustomerClientInterface;

class ConditionalAvailabilityPageSearchToCustomerClientBridgeTest extends Unit
{
    /**
     * @var \FondOfImpala\Client\ConditionalAvailabilityPageSearch\Dependency\Client\ConditionalAvailabilityPageSearchToCustomerClientBridge
     */
    protected ConditionalAvailabilityPageSearchToCustomerClientBridge $bridge;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\Customer\CustomerClientInterface
     */
    protected MockObject|CustomerClientInterface $customerClientInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CustomerTransfer
     */
    protected MockObject|CustomerTransfer $customerTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->customerClientInterfaceMock = $this->getMockBuilder(CustomerClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerTransferMock = $this->getMockBuilder(CustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bridge = new ConditionalAvailabilityPageSearchToCustomerClientBridge(
            $this->customerClientInterfaceMock,
        );
    }

    /**
     * @return void
     */
    public function testGetCustomer(): void
    {
        $this->customerClientInterfaceMock->expects(static::atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->customerTransferMock);

        static::assertEquals($this->customerTransferMock, $this->bridge->getCustomer());
    }
}
