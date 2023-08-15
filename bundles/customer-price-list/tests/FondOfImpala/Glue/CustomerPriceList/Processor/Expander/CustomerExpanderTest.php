<?php

namespace FondOfImpala\Glue\CustomerPriceList\Processor\Expander;

use Codeception\Test\Unit;
use FondOfImpala\Client\CustomerPriceList\CustomerPriceListClientInterface;
use Generated\Shared\Transfer\CustomerTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CustomerExpanderTest extends Unit
{
    /**
     * @var \FondOfImpala\Glue\CustomerPriceList\Processor\Expander\CustomerExpander
     */
    protected CustomerExpander $customerExpander;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Client\CustomerPriceList\CustomerPriceListClientInterface
     */
    protected MockObject|CustomerPriceListClientInterface $customerPriceListClientInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CustomerTransfer
     */
    protected MockObject|CustomerTransfer $customerTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->customerPriceListClientInterfaceMock = $this->getMockBuilder(CustomerPriceListClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerTransferMock = $this->getMockBuilder(CustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerExpander = new CustomerExpander($this->customerPriceListClientInterfaceMock);
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $this->customerPriceListClientInterfaceMock->expects($this->atLeastOnce())
            ->method('expandCustomer')
            ->with($this->customerTransferMock)
            ->willReturn($this->customerTransferMock);

        $this->assertEquals(
            $this->customerTransferMock,
            $this->customerExpander->expand($this->customerTransferMock),
        );
    }
}
