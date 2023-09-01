<?php

namespace FondOfImpala\Zed\CustomerPriceList\Communication\Plugin\Customer;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CustomerPriceList\Business\CustomerPriceListFacade;
use Generated\Shared\Transfer\CustomerTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class PriceListCustomerTransferExpanderPluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CustomerPriceList\Communication\Plugin\Customer\PriceListCustomerTransferExpanderPlugin
     */
    protected PriceListCustomerTransferExpanderPlugin $priceListCustomerTransferExpanderPlugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CustomerPriceList\Business\CustomerPriceListFacade
     */
    protected MockObject|CustomerPriceListFacade $customerPriceListFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CustomerTransfer
     */
    protected MockObject|CustomerTransfer $customerTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->customerPriceListFacadeMock = $this->getMockBuilder(CustomerPriceListFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerTransferMock = $this->getMockBuilder(CustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceListCustomerTransferExpanderPlugin = new PriceListCustomerTransferExpanderPlugin();
        $this->priceListCustomerTransferExpanderPlugin->setFacade($this->customerPriceListFacadeMock);
    }

    /**
     * @return void
     */
    public function testExpandTransfer(): void
    {
        $this->customerPriceListFacadeMock->expects($this->atLeastOnce())
            ->method('expandCustomer')
            ->with($this->customerTransferMock)
            ->willReturn($this->customerTransferMock);

        $this->assertEquals(
            $this->customerTransferMock,
            $this->priceListCustomerTransferExpanderPlugin->expandTransfer(
                $this->customerTransferMock,
            ),
        );
    }
}
