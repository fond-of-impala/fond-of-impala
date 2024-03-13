<?php

namespace FondOfImpala\Client\PriceProductPriceListSearchRestApiCompanyCurrencyConnector\Dependency\Client;

use Codeception\Test\Unit;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Client\ZedRequest\ZedRequestClientInterface;
use Spryker\Shared\Kernel\Transfer\TransferInterface;

class PriceProductPriceListSearchRestApiCompanyCurrencyConnectorToZedRequestClientBridgeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\ZedRequest\ZedRequestClientInterface
     */
    protected MockObject|ZedRequestClientInterface $zedRequestClientMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Shared\Kernel\Transfer\TransferInterface
     */
    protected MockObject|TransferInterface $transferMock;

    /**
     * @var \FondOfImpala\Client\PriceProductPriceListSearchRestApiCompanyCurrencyConnector\Dependency\Client\PriceProductPriceListSearchRestApiCompanyCurrencyConnectorToZedRequestClientBridge
     */
    protected PriceProductPriceListSearchRestApiCompanyCurrencyConnectorToZedRequestClientBridge $zedRequestClientBridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->zedRequestClientMock = $this->getMockBuilder(ZedRequestClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->transferMock = $this->getMockBuilder(TransferInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->zedRequestClientBridge = new PriceProductPriceListSearchRestApiCompanyCurrencyConnectorToZedRequestClientBridge(
            $this->zedRequestClientMock,
        );
    }

    /**
     * @return void
     */
    public function testCall(): void
    {
        $url = 'url';

        $this->zedRequestClientMock->expects(static::atLeastOnce())
            ->method('call')
            ->with($url, $this->transferMock, null)
            ->willReturn($this->transferMock);

        static::assertEquals(
            $this->transferMock,
            $this->zedRequestClientBridge->call($url, $this->transferMock),
        );
    }
}
