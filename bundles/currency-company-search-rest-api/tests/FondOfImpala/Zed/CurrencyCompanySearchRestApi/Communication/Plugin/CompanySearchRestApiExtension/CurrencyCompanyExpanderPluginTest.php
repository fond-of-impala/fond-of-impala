<?php

namespace FondOfImpala\Zed\CurrencyCompanySearchRestApi\Communication\Plugin\CompanySearchRestApiExtension;

use Codeception\Test\Unit;
use FondOfImpala\Zed\CurrencyCompanySearchRestApi\Communication\CurrencyCompanySearchRestApiCommunicationFactory;
use FondOfImpala\Zed\CurrencyCompanySearchRestApi\Dependency\Facade\CurrencyCompanySearchRestApiToCurrencyFacadeInterface;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CurrencyTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CurrencyCompanyExpanderPluginTest extends Unit
{
    protected CurrencyCompanySearchRestApiToCurrencyFacadeInterface|MockObject $currencyFacadeMock;

    protected CurrencyCompanySearchRestApiCommunicationFactory|MockObject $factoryMock;

    protected CompanyTransfer|MockObject $companyTransferMock;

    protected MockObject|CurrencyTransfer $currencyTransferMock;

    protected CurrencyCompanyExpanderPlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->currencyFacadeMock = $this->getMockBuilder(CurrencyCompanySearchRestApiToCurrencyFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factoryMock = $this->getMockBuilder(CurrencyCompanySearchRestApiCommunicationFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTransferMock = $this->getMockBuilder(CompanyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->currencyTransferMock = $this->getMockBuilder(CurrencyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new CurrencyCompanyExpanderPlugin();
        $this->plugin->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $idCurrency = 1;

        $this->companyTransferMock->expects(static::atLeastOnce())
            ->method('getFkCurrency')
            ->willReturn($idCurrency);

        $this->factoryMock->expects(static::atLeastOnce())
            ->method('getCurrencyFacade')
            ->willReturn($this->currencyFacadeMock);

        $this->currencyFacadeMock->expects(static::atLeastOnce())
            ->method('getByIdCurrency')
            ->with($idCurrency)
            ->willReturn($this->currencyTransferMock);

        $this->companyTransferMock->expects(static::atLeastOnce())
            ->method('setCurrency')
            ->with($this->currencyTransferMock)
            ->willReturn($this->companyTransferMock);

        static::assertEquals(
            $this->companyTransferMock,
            $this->plugin->expand($this->companyTransferMock),
        );
    }
}
