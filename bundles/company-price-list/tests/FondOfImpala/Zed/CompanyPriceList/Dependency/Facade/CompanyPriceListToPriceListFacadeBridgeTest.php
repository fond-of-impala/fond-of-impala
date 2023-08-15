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
    protected CompanyPriceListToPriceListFacadeBridge $companyPriceListToPriceListFacadeBridge;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\PriceList\Business\PriceListFacadeInterface
     */
    protected MockObject|PriceListFacadeInterface $priceListFacadeInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PriceListTransfer
     */
    protected MockObject|PriceListTransfer $priceListTransferMock;

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
        $this->priceListFacadeInterfaceMock->expects(static::atLeastOnce())
            ->method('findPriceListById')
            ->with($this->priceListTransferMock)
            ->willReturn($this->priceListTransferMock);

        static::assertInstanceOf(
            PriceListTransfer::class,
            $this->companyPriceListToPriceListFacadeBridge->findPriceListById(
                $this->priceListTransferMock,
            ),
        );
    }
}
