<?php

namespace FondOfImpala\Zed\CompanyPriceList\Communication\Plugin\CompanyExtension;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyPriceList\Business\CompanyPriceListFacade;
use Generated\Shared\Transfer\CompanyTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class PriceListCompanyHydrationPluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyPriceList\Communication\Plugin\CompanyExtension\PriceListCompanyHydrationPlugin
     */
    protected PriceListCompanyHydrationPlugin $priceListCompanyHydrationPlugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CompanyTransfer
     */
    protected MockObject|CompanyTransfer $companyTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\CompanyPriceList\Business\CompanyPriceListFacade
     */
    protected MockObject|CompanyPriceListFacade $companyPriceListFacadeMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->companyTransferMock = $this->getMockBuilder(CompanyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyPriceListFacadeMock = $this->getMockBuilder(CompanyPriceListFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceListCompanyHydrationPlugin = new PriceListCompanyHydrationPlugin();
        $this->priceListCompanyHydrationPlugin->setFacade($this->companyPriceListFacadeMock);
    }

    /**
     * @return void
     */
    public function testHydrate(): void
    {
        $this->companyPriceListFacadeMock->expects(static::atLeastOnce())
            ->method('hydrateCompany')
            ->with($this->companyTransferMock)
            ->willReturn($this->companyTransferMock);

        static::assertEquals(
            $this->companyTransferMock,
            $this->priceListCompanyHydrationPlugin->hydrate(
                $this->companyTransferMock,
            ),
        );
    }
}
