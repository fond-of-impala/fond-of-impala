<?php

namespace FondOfImpala\Client\ConditionalAvailabilityPageSearch\Dependency\Client;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CustomerTransfer;
use Spryker\Client\Customer\CustomerClientInterface;

class ConditionalAvailabilityPageSearchToCustomerClientBridgeTest extends Unit
{
    /**
     * @var \FondOfImpala\Client\ConditionalAvailabilityPageSearch\Dependency\Client\ConditionalAvailabilityPageSearchToCustomerClientBridge
     */
    protected $conditionalAvailabilityPageSearchToCustomerClientBridge;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\Customer\CustomerClientInterface
     */
    protected $customerClientInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CustomerTransfer
     */
    protected $customerTransferMock;

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

        $this->conditionalAvailabilityPageSearchToCustomerClientBridge = new ConditionalAvailabilityPageSearchToCustomerClientBridge(
            $this->customerClientInterfaceMock,
        );
    }

    /**
     * @return void
     */
    public function testGetCustomer(): void
    {
        $this->customerClientInterfaceMock->expects($this->atLeastOnce())
            ->method('getCustomer')
            ->willReturn($this->customerTransferMock);

        $this->assertInstanceOf(
            CustomerTransfer::class,
            $this->conditionalAvailabilityPageSearchToCustomerClientBridge->getCustomer(),
        );
    }
}
