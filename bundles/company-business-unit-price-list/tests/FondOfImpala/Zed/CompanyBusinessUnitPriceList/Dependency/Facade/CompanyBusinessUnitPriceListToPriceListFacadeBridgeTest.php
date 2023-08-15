<?php

namespace FondOfImpala\Zed\CompanyBusinessUnitPriceList\Dependency\Facade;

use Codeception\Test\Unit;
use FondOfImpala\Zed\PriceList\Business\PriceListFacadeInterface;
use Generated\Shared\Transfer\PriceListTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CompanyBusinessUnitPriceListToPriceListFacadeBridgeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyBusinessUnitPriceList\Dependency\Facade\CompanyBusinessUnitPriceListToPriceListFacadeBridge
     */
    protected CompanyBusinessUnitPriceListToPriceListFacadeBridge $companyBusinessUnitPriceListToPriceListFacadeBridge;

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
        parent::_before();

        $this->priceListFacadeInterfaceMock = $this->getMockBuilder(PriceListFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceListTransferMock = $this->getMockBuilder(PriceListTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitPriceListToPriceListFacadeBridge = new CompanyBusinessUnitPriceListToPriceListFacadeBridge(
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
            ->willReturn($this->priceListTransferMock);

        static::assertInstanceOf(
            PriceListTransfer::class,
            $this->companyBusinessUnitPriceListToPriceListFacadeBridge->findPriceListById(
                $this->priceListTransferMock,
            ),
        );
    }
}
