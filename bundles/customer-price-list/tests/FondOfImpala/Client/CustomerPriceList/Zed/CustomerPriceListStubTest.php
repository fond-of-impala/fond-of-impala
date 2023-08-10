<?php

namespace FondOfImpala\Client\CustomerPriceList\Zed;

use Codeception\Test\Unit;
use FondOfImpala\Client\CustomerPriceList\Dependency\Client\CustomerPriceListToZedRequestClientInterface;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\PriceListCollectionTransfer;

class CustomerPriceListStubTest extends Unit
{
    /**
     * @var \FondOfImpala\Client\CustomerPriceList\Zed\CustomerPriceListStub
     */
    protected $customerPriceListStub;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Client\CustomerPriceList\Dependency\Client\CustomerPriceListToZedRequestClientInterface
     */
    protected $customerPriceListToZedRequestClientInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CustomerTransfer
     */
    protected $customerTransferMock;

    /**
     * @var string
     */
    protected $expandCustomerUrl;

    /**
     * @var string
     */
    protected $getPriceListCollectionByIdCustomerUrl;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PriceListCollectionTransfer
     */
    protected $priceListCollectionTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->customerPriceListToZedRequestClientInterfaceMock = $this->getMockBuilder(CustomerPriceListToZedRequestClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerTransferMock = $this->getMockBuilder(CustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->expandCustomerUrl = '/customer-price-list/gateway/expand-customer';

        $this->getPriceListCollectionByIdCustomerUrl = '/customer-price-list/gateway/get-price-list-collection-by-id-customer';

        $this->priceListCollectionTransferMock = $this->getMockBuilder(PriceListCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerPriceListStub = new CustomerPriceListStub(
            $this->customerPriceListToZedRequestClientInterfaceMock,
        );
    }

    /**
     * @return void
     */
    public function testExpandCustomer(): void
    {
        $this->customerPriceListToZedRequestClientInterfaceMock->expects($this->atLeastOnce())
            ->method('call')
            ->with($this->expandCustomerUrl, $this->customerTransferMock)
            ->willReturn($this->customerTransferMock);

        $this->assertEquals(
            $this->customerTransferMock,
            $this->customerPriceListStub->expandCustomer(
                $this->customerTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testCustomerPriceListStub(): void
    {
        $this->customerPriceListToZedRequestClientInterfaceMock->expects($this->atLeastOnce())
            ->method('call')
            ->with($this->getPriceListCollectionByIdCustomerUrl, $this->customerTransferMock)
            ->willReturn($this->priceListCollectionTransferMock);

        $this->assertEquals(
            $this->priceListCollectionTransferMock,
            $this->customerPriceListStub->getPriceListCollectionByIdCustomer(
                $this->customerTransferMock,
            ),
        );
    }
}
