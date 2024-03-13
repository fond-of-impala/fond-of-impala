<?php

namespace FondOfImpala\Client\PriceProductPriceListSearchRestApiCompanyCurrencyConnector\Zed;

use Codeception\Test\Unit;
use FondOfImpala\Client\PriceProductPriceListSearchRestApiCompanyCurrencyConnector\Dependency\Client\PriceProductPriceListSearchRestApiCompanyCurrencyConnectorToZedRequestClientInterface;
use Generated\Shared\Transfer\CurrencyTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class PriceProductPriceListSearchRestApiCompanyCurrencyConnectorStubTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CurrencyTransfer
     */
    protected MockObject|CurrencyTransfer $currencyTransferMock;

    /**
     * @var \FondOfImpala\Client\PriceProductPriceListSearchRestApiCompanyCurrencyConnector\Dependency\Client\PriceProductPriceListSearchRestApiCompanyCurrencyConnectorToZedRequestClientInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|PriceProductPriceListSearchRestApiCompanyCurrencyConnectorToZedRequestClientInterface $zedRequestClientMock;

    /**
     * @var \FondOfImpala\Client\PriceProductPriceListSearchRestApiCompanyCurrencyConnector\Zed\PriceProductPriceListSearchRestApiCompanyCurrencyConnectorStub
     */
    protected PriceProductPriceListSearchRestApiCompanyCurrencyConnectorStub $stub;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->currencyTransferMock = $this->getMockBuilder(CurrencyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->zedRequestClientMock = $this->getMockBuilder(PriceProductPriceListSearchRestApiCompanyCurrencyConnectorToZedRequestClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->stub = new PriceProductPriceListSearchRestApiCompanyCurrencyConnectorStub($this->zedRequestClientMock);
    }

    /**
     * @return void
     */
    public function testFindPriceProductPriceListSearchRestApiCompanyCurrencyConnectors(): void
    {
        $this->zedRequestClientMock->expects(static::atLeastOnce())
            ->method('call')
            ->with(
                '/price-product-price-list-search-rest-api-company-currency-connector/gateway/get-currency-by-id',
                $this->currencyTransferMock,
            )->willReturn($this->currencyTransferMock);

        static::assertEquals(
            $this->currencyTransferMock,
            $this->stub->getCurrencyById($this->currencyTransferMock),
        );
    }
}
