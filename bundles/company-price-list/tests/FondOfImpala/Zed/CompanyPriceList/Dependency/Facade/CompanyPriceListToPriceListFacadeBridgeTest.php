<?php

namespace FondOfImpala\Zed\CompanyPriceList\Dependency\Facade;

use Codeception\Test\Unit;
use FondOfImpala\Zed\PriceList\Business\PriceListFacadeInterface;
use Generated\Shared\Transfer\PriceListTransfer;

class CompanyPriceListToPriceListFacadeBridgeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyPriceList\Dependency\Facade\CompanyPriceListToPriceListFacadeBridge
     */
    protected $companyPriceListToPriceListFacadeBridge;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\PriceList\Business\PriceListFacadeInterface
     */
    protected $priceListFacadeInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PriceListTransfer
     */
    protected $priceListTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->priceListFacadeInterfaceMock = $this->getMockBuilder(PriceListFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceListTransferMock = $this->getMockBuilder(PriceListTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyPriceListToPriceListFacadeBridge = new CompanyPriceListToPriceListFacadeBridge(
            $this->priceListFacadeInterfaceMock,
        );
    }

    /**
     * @return void
     */
    public function testFindPriceListById(): void
    {
        $this->priceListFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('findPriceListById')
            ->with($this->priceListTransferMock)
            ->willReturn($this->priceListTransferMock);

        $this->assertInstanceOf(
            PriceListTransfer::class,
            $this->companyPriceListToPriceListFacadeBridge->findPriceListById(
                $this->priceListTransferMock,
            ),
        );
    }
}
