<?php

namespace FondOfImpala\Zed\CompanyUserCartsRestApiCompanyCurrencyConnector\Dependency\Facade;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\StoreWithCurrencyTransfer;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Zed\Currency\Business\CurrencyFacadeInterface;

class CompanyUserCartsRestApiCompanyCurrencyConnectorToCurrencyFacadeBridgeTest extends Unit
{
    /**
     * @var \Spryker\Zed\Currency\Business\CurrencyFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected CurrencyFacadeInterface|MockObject $facadeMock;

    /**
     * @var \Generated\Shared\Transfer\QuoteResponseTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $quoteResponseTransferMock;

    /**
     * @var \Generated\Shared\Transfer\StoreWithCurrencyTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected StoreWithCurrencyTransfer|MockObject $storeWithCurrencyTransferMock;

    /**
     * @var \FondOfImpala\Zed\CompanyUserCartsRestApiCompanyCurrencyConnector\Dependency\Facade\CompanyUserCartsRestApiCompanyCurrencyConnectorToCurrencyFacadeBridge
     */
    protected CompanyUserCartsRestApiCompanyCurrencyConnectorToCurrencyFacadeBridge $bridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->facadeMock = $this->getMockBuilder(CurrencyFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->storeWithCurrencyTransferMock = $this->getMockBuilder(StoreWithCurrencyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bridge = new CompanyUserCartsRestApiCompanyCurrencyConnectorToCurrencyFacadeBridge($this->facadeMock);
    }

    /**
     * @return void
     */
    public function testFindQuoteByUuid(): void
    {
        $this->facadeMock->expects(static::atLeastOnce())
            ->method('getCurrentStoreWithCurrencies')
            ->willReturn($this->storeWithCurrencyTransferMock);

        static::assertEquals(
            $this->storeWithCurrencyTransferMock,
            $this->bridge->getCurrentStoreWithCurrencies(),
        );
    }
}
