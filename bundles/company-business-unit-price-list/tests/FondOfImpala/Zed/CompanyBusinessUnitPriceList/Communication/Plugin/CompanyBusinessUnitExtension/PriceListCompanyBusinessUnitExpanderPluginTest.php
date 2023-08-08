<?php

namespace FondOfImpala\Zed\CompanyBusinessUnitPriceList\Communication\Plugin\CompanyBusinessUnitExtension;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyBusinessUnitPriceList\Business\CompanyBusinessUnitPriceListFacade;
use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;

class PriceListCompanyBusinessUnitExpanderPluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyBusinessUnitPriceList\Communication\Plugin\CompanyBusinessUnitExtension\PriceListCompanyBusinessUnitExpanderPlugin
     */
    protected $priceListCompanyBusinessUnitExpanderPlugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyBusinessUnitPriceList\Business\CompanyBusinessUnitPriceListFacade
     */
    protected $companyBusinessUnitPriceListFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyBusinessUnitTransfer
     */
    protected $companyBusinessUnitTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyBusinessUnitPriceListFacadeMock = $this->getMockBuilder(CompanyBusinessUnitPriceListFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitTransferMock = $this->getMockBuilder(CompanyBusinessUnitTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceListCompanyBusinessUnitExpanderPlugin = new PriceListCompanyBusinessUnitExpanderPlugin();
        $this->priceListCompanyBusinessUnitExpanderPlugin->setFacade($this->companyBusinessUnitPriceListFacadeMock);
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $this->companyBusinessUnitPriceListFacadeMock->expects($this->atLeastOnce())
            ->method('expandCompanyBusinessUnit')
            ->willReturn($this->companyBusinessUnitTransferMock);

        $this->assertInstanceOf(
            CompanyBusinessUnitTransfer::class,
            $this->priceListCompanyBusinessUnitExpanderPlugin->expand(
                $this->companyBusinessUnitTransferMock,
            ),
        );
    }
}
