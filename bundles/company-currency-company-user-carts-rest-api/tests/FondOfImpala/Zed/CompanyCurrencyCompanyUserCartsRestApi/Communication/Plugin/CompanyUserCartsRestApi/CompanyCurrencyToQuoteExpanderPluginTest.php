<?php

namespace FondOfImpala\Zed\CompanyCurrencyCompanyUserCartsRestApi\Communication\Plugin\PermissionExtension;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfImpala\Zed\CompanyCurrencyCompanyUserCartsRestApi\Communication\CompanyCurrencyCompanyUserCartsRestApiCommunicationFactory;
use FondOfImpala\Zed\CompanyCurrencyCompanyUserCartsRestApi\Communication\Plugin\CompanyUserCartsRestApi\CompanyCurrencyToQuoteExpanderPlugin;
use FondOfImpala\Zed\CompanyCurrencyCompanyUserCartsRestApi\Dependency\Facade\CompanyCurrencyCompanyUserCartsRestApiToCurrencyFacadeInterface;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\CurrencyTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer;
use Generated\Shared\Transfer\StoreWithCurrencyTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CompanyCurrencyToQuoteExpanderPluginTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\CompanyCurrencyCompanyUserCartsRestApi\Communication\Plugin\CompanyUserCartsRestApi\CompanyCurrencyToQuoteExpanderPlugin
     */
    protected CompanyCurrencyToQuoteExpanderPlugin $plugin;

    /**
     * @var \FondOfImpala\Zed\CompanyCurrencyCompanyUserCartsRestApi\Communication\CompanyCurrencyCompanyUserCartsRestApiCommunicationFactory|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyCurrencyCompanyUserCartsRestApiCommunicationFactory|MockObject $factoryMock;

    /**
     * @var \FondOfImpala\Zed\CompanyCurrencyCompanyUserCartsRestApi\Dependency\Facade\CompanyCurrencyCompanyUserCartsRestApiToCurrencyFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyCurrencyCompanyUserCartsRestApiToCurrencyFacadeInterface|MockObject $currencyFacadeMock;

    /**
     * @var \Generated\Shared\Transfer\QuoteTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected QuoteTransfer|MockObject $quoteTransferMock;

    /**
     * @var \Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected RestCompanyUserCartsRequestTransfer|MockObject $restCompanyUserCartsRequestTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyUserTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyUserTransfer|MockObject $companyUserTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CompanyTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CompanyTransfer|MockObject $companyTransferMock;

    /**
     * @var \Generated\Shared\Transfer\StoreWithCurrencyTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected StoreWithCurrencyTransfer|MockObject $storeWithCurrencyTransferMock;

    /**
     * @var \Generated\Shared\Transfer\CurrencyTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CurrencyTransfer|MockObject $currencyTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->factoryMock = $this->getMockBuilder(CompanyCurrencyCompanyUserCartsRestApiCommunicationFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->currencyFacadeMock = $this->getMockBuilder(CompanyCurrencyCompanyUserCartsRestApiToCurrencyFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyUserTransferMock = $this->getMockBuilder(CompanyUserTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTransferMock = $this->getMockBuilder(CompanyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCompanyUserCartsRequestTransferMock = $this->getMockBuilder(RestCompanyUserCartsRequestTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->storeWithCurrencyTransferMock = $this->getMockBuilder(StoreWithCurrencyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->currencyTransferMock = $this->getMockBuilder(CurrencyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new CompanyCurrencyToQuoteExpanderPlugin();
        $this->plugin->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $currencyCollection = new ArrayObject();
        $currencyCollection->append($this->currencyTransferMock);

        $this->quoteTransferMock
            ->expects(static::atLeastOnce())
            ->method('getCompanyUser')
            ->willReturn($this->companyUserTransferMock);

        $this->companyUserTransferMock
            ->expects(static::atLeastOnce())
            ->method('getCompany')
            ->willReturn($this->companyTransferMock);

        $this->factoryMock
            ->expects(static::atLeastOnce())
            ->method('getCurrencyFacade')
            ->willReturn($this->currencyFacadeMock);

        $this->currencyFacadeMock
            ->expects(static::atLeastOnce())
            ->method('getCurrentStoreWithCurrencies')
            ->willReturn($this->storeWithCurrencyTransferMock);

        $this->storeWithCurrencyTransferMock
            ->expects(static::atLeastOnce())
            ->method('getCurrencies')
            ->willReturn($currencyCollection);

        $this->currencyTransferMock
            ->expects(static::atLeastOnce())
            ->method('getIdCurrency')
            ->willReturn(46);

        $this->companyTransferMock
            ->expects(static::atLeastOnce())
            ->method('getFkCurrency')
            ->willReturn(46);

        $this->quoteTransferMock
            ->expects(static::atLeastOnce())
            ->method('setCurrency')
            ->with($this->currencyTransferMock)
            ->willReturnSelf();

        static::assertEquals(
            $this->quoteTransferMock,
            $this->plugin->expand($this->quoteTransferMock, $this->restCompanyUserCartsRequestTransferMock),
        );
    }
}
