<?php

namespace FondOfImpala\Client\CompanyCurrencyPriceProductPriceListSearchRestApi\Zed;

use Codeception\Test\Unit;
use FondOfImpala\Client\CompanyCurrencyPriceProductPriceListSearchRestApi\Dependency\Client\CompanyCurrencyPriceProductPriceListSearchRestApiToZedRequestClientInterface;
use Generated\Shared\Transfer\CurrencyTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CompanyCurrencyPriceProductPriceListSearchRestApiStubTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CurrencyTransfer
     */
    protected MockObject|CurrencyTransfer $currencyTransferMock;

    /**
     * @var \FondOfImpala\Client\CompanyCurrencyPriceProductPriceListSearchRestApi\Dependency\Client\CompanyCurrencyPriceProductPriceListSearchRestApiToZedRequestClientInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|CompanyCurrencyPriceProductPriceListSearchRestApiToZedRequestClientInterface $zedRequestClientMock;

    /**
     * @var \FondOfImpala\Client\CompanyCurrencyPriceProductPriceListSearchRestApi\Zed\CompanyCurrencyPriceProductPriceListSearchRestApiStub
     */
    protected CompanyCurrencyPriceProductPriceListSearchRestApiStub $stub;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->currencyTransferMock = $this->getMockBuilder(CurrencyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->zedRequestClientMock = $this->getMockBuilder(CompanyCurrencyPriceProductPriceListSearchRestApiToZedRequestClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->stub = new CompanyCurrencyPriceProductPriceListSearchRestApiStub($this->zedRequestClientMock);
    }

    /**
     * @return void
     */
    public function testFindCompanyCurrencyPriceProductPriceListSearchRestApis(): void
    {
        $this->zedRequestClientMock->expects(static::atLeastOnce())
            ->method('call')
            ->with(
                '/company-currency-price-product-price-list-search-rest-api/gateway/get-currency-by-id',
                $this->currencyTransferMock,
            )->willReturn($this->currencyTransferMock);

        static::assertEquals(
            $this->currencyTransferMock,
            $this->stub->getCurrencyById($this->currencyTransferMock),
        );
    }
}
