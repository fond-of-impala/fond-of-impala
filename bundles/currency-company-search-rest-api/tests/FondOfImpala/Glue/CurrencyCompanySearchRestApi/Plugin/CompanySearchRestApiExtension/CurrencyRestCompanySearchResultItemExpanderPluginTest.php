<?php

namespace FondOfImpala\Glue\CurrencyCompanySearchRestApi\Plugin\CompanySearchRestApiExtension;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CurrencyTransfer;
use Generated\Shared\Transfer\RestCompanySearchResultItemTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CurrencyRestCompanySearchResultItemExpanderPluginTest extends Unit
{
    protected CompanyTransfer|MockObject $companyTransferMock;

    protected MockObject|CurrencyTransfer $currencyTransferMock;

    protected RestCompanySearchResultItemTransfer|MockObject $restCompanySearchResultItemTransferMock;

    protected CurrencyRestCompanySearchResultItemExpanderPlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyTransferMock = $this->getMockBuilder(CompanyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->currencyTransferMock = $this->getMockBuilder(CurrencyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanySearchResultItemTransferMock = $this->getMockBuilder(RestCompanySearchResultItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new CurrencyRestCompanySearchResultItemExpanderPlugin();
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $currencyIsoCode = 'EUR';

        $this->companyTransferMock->expects(static::atLeastOnce())
            ->method('getCurrency')
            ->willReturn($this->currencyTransferMock);

        $this->currencyTransferMock->expects(static::atLeastOnce())
            ->method('getCode')
            ->willReturn($currencyIsoCode);

        $this->restCompanySearchResultItemTransferMock->expects(static::atLeastOnce())
            ->method('setCurrencyIsoCode')
            ->with($currencyIsoCode)
            ->willReturn($this->restCompanySearchResultItemTransferMock);

        static::assertEquals(
            $this->restCompanySearchResultItemTransferMock,
            $this->plugin->expand(
                $this->restCompanySearchResultItemTransferMock,
                $this->companyTransferMock,
            ),
        );
    }

    /**
     * @return void
     */
    public function testExpandWithoutCurrency(): void
    {
        $this->companyTransferMock->expects(static::atLeastOnce())
            ->method('getCurrency')
            ->willReturn(null);

        $this->restCompanySearchResultItemTransferMock->expects(static::never())
            ->method('setCurrencyIsoCode');

        static::assertEquals(
            $this->restCompanySearchResultItemTransferMock,
            $this->plugin->expand(
                $this->restCompanySearchResultItemTransferMock,
                $this->companyTransferMock,
            ),
        );
    }
}
