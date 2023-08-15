<?php

namespace FondOfImpala\Zed\CompanyBusinessUnitPriceList\Communication\Plugin\CompanyBusinessUnitExtension;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyBusinessUnitPriceList\Business\CompanyBusinessUnitPriceListFacade;
use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class PriceListCompanyBusinessUnitExpanderPluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyBusinessUnitPriceList\Communication\Plugin\CompanyBusinessUnitExtension\PriceListCompanyBusinessUnitExpanderPlugin
     */
    protected PriceListCompanyBusinessUnitExpanderPlugin $priceListCompanyBusinessUnitExpanderPlugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyBusinessUnitPriceList\Business\CompanyBusinessUnitPriceListFacade
     */
    protected MockObject|CompanyBusinessUnitPriceListFacade $companyBusinessUnitPriceListFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyBusinessUnitTransfer
     */
    protected MockObject|CompanyBusinessUnitPriceListFacade $companyBusinessUnitTransferMock;

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
        $this->companyBusinessUnitPriceListFacadeMock->expects(static::atLeastOnce())
            ->method('expandCompanyBusinessUnit')
            ->willReturn($this->companyBusinessUnitTransferMock);

        static::assertInstanceOf(
            CompanyBusinessUnitTransfer::class,
            $this->priceListCompanyBusinessUnitExpanderPlugin->expand(
                $this->companyBusinessUnitTransferMock,
            ),
        );
    }
}
