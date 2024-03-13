<?php

namespace FondOfImpala\Client\ProductListConditionalAvailabilityPageSearch\Dependency\Client;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CustomerTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Client\Customer\CustomerClientInterface;

class ProductListConditionalAvailabilityPageSearchToCustomerClientBridgeTest extends Unit
{
    protected ProductListConditionalAvailabilityPageSearchToCustomerClientBridge $bridge;

    protected MockObject|CustomerClientInterface $customerClientInterfaceMock;

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

        $this->bridge = new ProductListConditionalAvailabilityPageSearchToCustomerClientBridge(
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
