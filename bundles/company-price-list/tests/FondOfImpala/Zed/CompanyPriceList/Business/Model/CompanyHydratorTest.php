<?php

namespace FondOfImpala\Zed\CompanyPriceList\Business\Model;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyPriceList\Dependency\Facade\CompanyPriceListToPriceListFacadeInterface;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\PriceListTransfer;

class CompanyHydratorTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyPriceList\Business\Model\CompanyHydrator
     */
    protected $companyHydrator;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyPriceList\Dependency\Facade\CompanyPriceListToPriceListFacadeInterface
     */
    protected $companyPriceListToPriceListFacadeInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyTransfer
     */
    protected $companyTransferMock;

    /**
     * @var int
     */
    protected $idPriceList;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PriceListTransfer
     */
    protected $priceListTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->companyPriceListToPriceListFacadeInterfaceMock = $this->getMockBuilder(CompanyPriceListToPriceListFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTransferMock = $this->getMockBuilder(CompanyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceListTransferMock = $this->getMockBuilder(PriceListTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->idPriceList = 1;

        $this->companyHydrator = new CompanyHydrator(
            $this->companyPriceListToPriceListFacadeInterfaceMock,
        );
    }

    /**
     * @return void
     */
    public function testHydrate(): void
    {
        $this->companyTransferMock->expects($this->atLeastOnce())
            ->method('getFkPriceList')
            ->willReturn($this->idPriceList);

        $this->companyPriceListToPriceListFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('findPriceListById')
            ->willReturn($this->priceListTransferMock);

        $this->companyTransferMock->expects($this->atLeastOnce())
            ->method('setPriceList')
            ->with($this->priceListTransferMock)
            ->willReturn($this->companyTransferMock);

        $this->assertInstanceOf(
            CompanyTransfer::class,
            $this->companyHydrator->hydrate(
                $this->companyTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testHydrateIdPriceListNull(): void
    {
        $this->companyTransferMock->expects($this->atLeastOnce())
            ->method('getFkPriceList')
            ->willReturn(null);

        $this->assertInstanceOf(
            CompanyTransfer::class,
            $this->companyHydrator->hydrate(
                $this->companyTransferMock,
            ),
        );
    }
}
