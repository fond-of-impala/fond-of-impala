<?php

namespace FondOfImpala\Zed\CustomerPriceList\Business\Model;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CustomerPriceList\Persistence\CustomerPriceListRepositoryInterface;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\PriceListCollectionTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CustomerExpanderTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CustomerPriceList\Business\Model\CustomerExpander
     */
    protected CustomerExpander $customerExpander;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CustomerPriceList\Persistence\CustomerPriceListRepositoryInterface
     */
    protected MockObject|CustomerPriceListRepositoryInterface $customerPriceListRepositoryInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CustomerTransfer
     */
    protected MockObject|CustomerTransfer $customerTransferMock;

    /**
     * @var int
     */
    protected int $idCustomer;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PriceListCollectionTransfer
     */
    protected MockObject|PriceListCollectionTransfer $priceListCollectionTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->customerPriceListRepositoryInterfaceMock = $this->getMockBuilder(CustomerPriceListRepositoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerTransferMock = $this->getMockBuilder(CustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceListCollectionTransferMock = $this->getMockBuilder(PriceListCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->idCustomer = 1;

        $this->customerExpander = new CustomerExpander(
            $this->customerPriceListRepositoryInterfaceMock,
        );
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $this->customerTransferMock->expects($this->atLeastOnce())
            ->method('getIdCustomer')
            ->willReturn($this->idCustomer);

        $this->customerPriceListRepositoryInterfaceMock->expects($this->atLeastOnce())
            ->method('getPriceListCollectionByIdCustomer')
            ->with($this->idCustomer)
            ->willReturn($this->priceListCollectionTransferMock);

        $this->customerTransferMock->expects($this->atLeastOnce())
            ->method('setPriceListCollection')
            ->with($this->priceListCollectionTransferMock)
            ->willReturnSelf();

        $this->assertEquals(
            $this->customerTransferMock,
            $this->customerExpander->expand(
                $this->customerTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testExpandIdCustomerNull(): void
    {
        $this->customerTransferMock->expects($this->atLeastOnce())
            ->method('getIdCustomer')
            ->willReturn(null);

        $this->assertEquals(
            $this->customerTransferMock,
            $this->customerExpander->expand(
                $this->customerTransferMock,
            ),
        );
    }
}
