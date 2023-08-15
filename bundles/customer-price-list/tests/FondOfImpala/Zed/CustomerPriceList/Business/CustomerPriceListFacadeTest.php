<?php

namespace FondOfImpala\Zed\CustomerPriceList\Business;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CustomerPriceList\Business\Model\CustomerExpanderInterface;
use FondOfImpala\Zed\CustomerPriceList\Business\Model\CustomerPriceListReaderInterface;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\PriceListCollectionTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CustomerPriceListFacadeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CustomerPriceList\Business\CustomerPriceListFacade
     */
    protected CustomerPriceListFacade $customerPriceListFacade;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CustomerTransfer
     */
    protected MockObject|CustomerTransfer $customerTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CustomerPriceList\Business\CustomerPriceListBusinessFactory
     */
    protected MockObject|CustomerPriceListBusinessFactory $customerPriceListBusinessFactoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CustomerPriceList\Business\Model\CustomerExpanderInterface
     */
    protected MockObject|CustomerExpanderInterface $customerExpanderInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CustomerPriceList\Business\Model\CustomerPriceListReaderInterface
     */
    protected MockObject|CustomerPriceListReaderInterface $customerPriceListReaderInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PriceListCollectionTransfer
     */
    protected MockObject|PriceListCollectionTransfer $priceListCollectionTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->customerPriceListBusinessFactoryMock = $this->getMockBuilder(CustomerPriceListBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerTransferMock = $this->getMockBuilder(CustomerTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerExpanderInterfaceMock = $this->getMockBuilder(CustomerExpanderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerPriceListReaderInterfaceMock = $this->getMockBuilder(CustomerPriceListReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceListCollectionTransferMock = $this->getMockBuilder(PriceListCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerPriceListFacade = new CustomerPriceListFacade();
        $this->customerPriceListFacade->setFactory($this->customerPriceListBusinessFactoryMock);
    }

    /**
     * @return void
     */
    public function testExpandCustomer(): void
    {
        $this->customerPriceListBusinessFactoryMock->expects($this->atLeastOnce())
            ->method('createCustomerExpander')
            ->willReturn($this->customerExpanderInterfaceMock);

        $this->customerExpanderInterfaceMock->expects($this->atLeastOnce())
            ->method('expand')
            ->with($this->customerTransferMock)
            ->willReturn($this->customerTransferMock);

        $this->assertEquals(
            $this->customerTransferMock,
            $this->customerPriceListFacade->expandCustomer(
                $this->customerTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testGetPriceListCollectionByIdCustomer(): void
    {
        $this->customerPriceListBusinessFactoryMock->expects($this->atLeastOnce())
            ->method('createCustomerPriceListReader')
            ->willReturn($this->customerPriceListReaderInterfaceMock);

        $this->customerPriceListReaderInterfaceMock->expects($this->atLeastOnce())
            ->method('getPriceListCollectionByIdCustomer')
            ->with($this->customerTransferMock)
            ->willReturn($this->priceListCollectionTransferMock);

        $this->assertEquals(
            $this->priceListCollectionTransferMock,
            $this->customerPriceListFacade->getPriceListCollectionByIdCustomer(
                $this->customerTransferMock,
            ),
        );
    }
}
