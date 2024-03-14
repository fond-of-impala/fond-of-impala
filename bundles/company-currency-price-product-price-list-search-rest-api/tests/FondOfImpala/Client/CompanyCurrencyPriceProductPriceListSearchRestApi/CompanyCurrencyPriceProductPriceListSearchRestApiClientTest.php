<?php

namespace FondOfImpala\Client\CompanyCurrencyPriceProductPriceListSearchRestApi;

use Codeception\Test\Unit;
use FondOfImpala\Client\CompanyCurrencyPriceProductPriceListSearchRestApi\Zed\CompanyCurrencyPriceProductPriceListSearchRestApiStubInterface;
use Generated\Shared\Transfer\CurrencyTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CompanyCurrencyPriceProductPriceListSearchRestApiClientTest extends Unit
{
    /**
     * @var \FondOfImpala\Client\CompanyCurrencyPriceProductPriceListSearchRestApi\CompanyCurrencyPriceProductPriceListSearchRestApiFactory|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|CompanyCurrencyPriceProductPriceListSearchRestApiFactory $factoryMock;

    /**
     * @var \FondOfImpala\Client\CompanyCurrencyPriceProductPriceListSearchRestApi\Zed\CompanyCurrencyPriceProductPriceListSearchRestApiStubInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|CompanyCurrencyPriceProductPriceListSearchRestApiStubInterface $zedStubMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CurrencyTransfer
     */
    protected MockObject|CurrencyTransfer $currencyTransferMock;

    /**
     * @var \FondOfImpala\Client\CompanyCurrencyPriceProductPriceListSearchRestApi\CompanyCurrencyPriceProductPriceListSearchRestApiClient
     */
    protected CompanyCurrencyPriceProductPriceListSearchRestApiClient $client;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->factoryMock = $this->getMockBuilder(CompanyCurrencyPriceProductPriceListSearchRestApiFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->zedStubMock = $this->getMockBuilder(CompanyCurrencyPriceProductPriceListSearchRestApiStubInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->currencyTransferMock = $this->getMockBuilder(CurrencyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->client = new CompanyCurrencyPriceProductPriceListSearchRestApiClient();
        $this->client->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testFindCompanyCurrencyPriceProductPriceListSearchRestApis(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createZedStub')
            ->willReturn($this->zedStubMock);

        $this->zedStubMock->expects(static::atLeastOnce())
            ->method('getCurrencyById')
            ->with($this->currencyTransferMock)
            ->willReturn($this->currencyTransferMock);

        static::assertEquals(
            $this->currencyTransferMock,
            $this->client->getCurrencyById($this->currencyTransferMock),
        );
    }
}
