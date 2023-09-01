<?php

namespace FondOfImpala\Zed\CustomerPriceList\Business\Model;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CustomerPriceList\Persistence\CustomerPriceListRepositoryInterface;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\PriceListCollectionTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CustomerPriceListReaderTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CustomerPriceList\Business\Model\CustomerPriceListReader
     */
    protected CustomerPriceListReader $customerPriceListReader;

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

        $this->idCustomer = 1;

        $this->priceListCollectionTransferMock = $this->getMockBuilder(PriceListCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerPriceListReader = new CustomerPriceListReader(
            $this->customerPriceListRepositoryInterfaceMock,
        );
    }

    /**
     * @return void
     */
    public function testGetPriceListCollectionByIdCustomer(): void
    {
        $this->customerTransferMock->expects($this->atLeastOnce())
            ->method('requireIdCustomer')
            ->willReturnSelf();

        $this->customerTransferMock->expects($this->atLeastOnce())
            ->method('getIdCustomer')
            ->willReturn($this->idCustomer);

        $this->customerPriceListRepositoryInterfaceMock->expects($this->atLeastOnce())
            ->method('getPriceListCollectionByIdCustomer')
            ->with($this->idCustomer)
            ->willReturn($this->priceListCollectionTransferMock);

        $this->assertEquals(
            $this->priceListCollectionTransferMock,
            $this->customerPriceListReader->getPriceListCollectionByIdCustomer(
                $this->customerTransferMock,
            ),
        );
    }
}
