<?php

namespace FondOfImpala\Client\CustomerPriceList;

use Codeception\Test\Unit;
use FondOfImpala\Client\CustomerPriceList\Zed\CustomerPriceListStubInterface;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\PriceListCollectionTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CustomerPriceListClientTest extends Unit
{
    /**
     * @var \FondOfImpala\Client\CustomerPriceList\CustomerPriceListClient
     */
    protected CustomerPriceListClient $customerPriceListClient;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CustomerTransfer
     */
    protected MockObject|CustomerTransfer $customerTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Client\CustomerPriceList\CustomerPriceListFactory
     */
    protected MockObject|CustomerPriceListFactory $customerPriceListFactoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Client\CustomerPriceList\Zed\CustomerPriceListStubInterface
     */
    protected MockObject|CustomerPriceListStubInterface $customerPriceListStubInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PriceListCollectionTransfer
     */
    protected MockObject|PriceListCollectionTransfer $priceListCollectionTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->customerPriceListFactoryMock = $this->getMockBuilder(CustomerPriceListFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerTransferMock = $this->getMockBuilder(CustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerPriceListStubInterfaceMock = $this->getMockBuilder(CustomerPriceListStubInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceListCollectionTransferMock = $this->getMockBuilder(PriceListCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerPriceListClient = new CustomerPriceListClient();
        $this->customerPriceListClient->setFactory($this->customerPriceListFactoryMock);
    }

    /**
     * @return void
     */
    public function testExpandCustomer(): void
    {
        $this->customerPriceListFactoryMock->expects($this->atLeastOnce())
            ->method('createZedStub')
            ->willReturn($this->customerPriceListStubInterfaceMock);

        $this->customerPriceListStubInterfaceMock->expects($this->atLeastOnce())
            ->method('expandCustomer')
            ->with($this->customerTransferMock)
            ->willReturn($this->customerTransferMock);

        $this->assertEquals(
            $this->customerTransferMock,
            $this->customerPriceListClient->expandCustomer(
                $this->customerTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testGetPriceListCollectionByIdCustomer(): void
    {
        $this->customerPriceListFactoryMock->expects($this->atLeastOnce())
            ->method('createZedStub')
            ->willReturn($this->customerPriceListStubInterfaceMock);

        $this->customerPriceListStubInterfaceMock->expects($this->atLeastOnce())
            ->method('getPriceListCollectionByIdCustomer')
            ->with($this->customerTransferMock)
            ->willReturn($this->priceListCollectionTransferMock);

        $this->assertEquals(
            $this->priceListCollectionTransferMock,
            $this->customerPriceListClient->getPriceListCollectionByIdCustomer(
                $this->customerTransferMock,
            ),
        );
    }
}
