<?php

namespace FondOfImpala\Client\PriceProductPriceListSearchRestApiCompanyCurrencyConnector;

use Codeception\Test\Unit;
use FondOfImpala\Client\PriceProductPriceListSearchRestApiCompanyCurrencyConnector\Zed\PriceProductPriceListSearchRestApiCompanyCurrencyConnectorStubInterface;
use Generated\Shared\Transfer\CurrencyTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class PriceProductPriceListSearchRestApiCompanyCurrencyConnectorClientTest extends Unit
{
    /**
     * @var \FondOfImpala\Client\PriceProductPriceListSearchRestApiCompanyCurrencyConnector\PriceProductPriceListSearchRestApiCompanyCurrencyConnectorFactory|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|PriceProductPriceListSearchRestApiCompanyCurrencyConnectorFactory $factoryMock;

    /**
     * @var \FondOfImpala\Client\PriceProductPriceListSearchRestApiCompanyCurrencyConnector\Zed\PriceProductPriceListSearchRestApiCompanyCurrencyConnectorStubInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected MockObject|PriceProductPriceListSearchRestApiCompanyCurrencyConnectorStubInterface $zedStubMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\CurrencyTransfer
     */
    protected MockObject|CurrencyTransfer $currencyTransferMock;

    /**
     * @var \FondOfImpala\Client\PriceProductPriceListSearchRestApiCompanyCurrencyConnector\PriceProductPriceListSearchRestApiCompanyCurrencyConnectorClient
     */
    protected PriceProductPriceListSearchRestApiCompanyCurrencyConnectorClient $client;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->factoryMock = $this->getMockBuilder(PriceProductPriceListSearchRestApiCompanyCurrencyConnectorFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->zedStubMock = $this->getMockBuilder(PriceProductPriceListSearchRestApiCompanyCurrencyConnectorStubInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->currencyTransferMock = $this->getMockBuilder(CurrencyTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->client = new PriceProductPriceListSearchRestApiCompanyCurrencyConnectorClient();
        $this->client->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testFindPriceProductPriceListSearchRestApiCompanyCurrencyConnectors(): void
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
