<?php

namespace FondOfImpala\Zed\CompanyBusinessUnitPriceList\Business\Model;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyBusinessUnitPriceList\Dependency\Facade\CompanyBusinessUnitPriceListToPriceListFacadeInterface;
use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\PriceListTransfer;

class CompanyBusinessUnitExpanderTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyBusinessUnitPriceList\Business\Model\CompanyBusinessUnitExpander
     */
    protected $companyBusinessUnitExpander;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyBusinessUnitPriceList\Dependency\Facade\CompanyBusinessUnitPriceListToPriceListFacadeInterface
     */
    protected $priceListFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyBusinessUnitTransfer
     */
    protected $companyBusinessUnitTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyTransfer
     */
    protected $companyTransferMock;

    /**
     * @var int
     */
    protected $fkPriceList;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\PriceListTransfer
     */
    protected $priceListTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->priceListFacadeMock = $this->getMockBuilder(CompanyBusinessUnitPriceListToPriceListFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitTransferMock = $this->getMockBuilder(CompanyBusinessUnitTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTransferMock = $this->getMockBuilder(CompanyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->fkPriceList = 1;

        $this->priceListTransferMock = $this->getMockBuilder(PriceListTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitExpander = new CompanyBusinessUnitExpander(
            $this->priceListFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $this->companyBusinessUnitTransferMock->expects($this->atLeastOnce())
            ->method('getCompany')
            ->willReturn($this->companyTransferMock);

        $this->companyTransferMock->expects($this->atLeastOnce())
            ->method('getFkPriceList')
            ->willReturn($this->fkPriceList);

        $this->priceListFacadeMock->expects($this->atLeastOnce())
            ->method('findPriceListById')
            ->willReturn($this->priceListTransferMock);

        $this->companyTransferMock->expects($this->atLeastOnce())
            ->method('setPriceList')
            ->willReturn($this->companyTransferMock);

        $this->assertInstanceOf(
            CompanyBusinessUnitTransfer::class,
            $this->companyBusinessUnitExpander->expand(
                $this->companyBusinessUnitTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testExpandCompanyTransferNull(): void
    {
        $this->companyBusinessUnitTransferMock->expects($this->atLeastOnce())
            ->method('getCompany')
            ->willReturn(null);

        $this->assertInstanceOf(
            CompanyBusinessUnitTransfer::class,
            $this->companyBusinessUnitExpander->expand(
                $this->companyBusinessUnitTransferMock,
            ),
        );
    }
}
