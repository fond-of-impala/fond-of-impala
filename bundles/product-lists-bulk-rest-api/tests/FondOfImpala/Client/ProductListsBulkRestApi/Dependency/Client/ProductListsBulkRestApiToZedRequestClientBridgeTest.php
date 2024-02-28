<?php

namespace FondOfImpala\Client\ProductListsBulkRestApi\Dependency\Client;

use Codeception\Test\Unit;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Client\ZedRequest\ZedRequestClientInterface;
use Spryker\Shared\Kernel\Transfer\TransferInterface;

class ProductListsBulkRestApiToZedRequestClientBridgeTest extends Unit
{
    protected MockObject|ZedRequestClientInterface $clientMock;

    protected MockObject|TransferInterface $transferMock;

    protected ProductListsBulkRestApiToZedRequestClientBridge $bridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->clientMock = $this->getMockBuilder(ZedRequestClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->transferMock = $this->getMockBuilder(TransferInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bridge = new ProductListsBulkRestApiToZedRequestClientBridge(
            $this->clientMock,
        );
    }

    /**
     * @return void
     */
    public function testCall(): void
    {
        $url = 'url';

        $this->clientMock->expects(static::atLeastOnce())
            ->method('call')
            ->with($url, $this->transferMock, null)
            ->willReturn($this->transferMock);

        static::assertEquals(
            $this->transferMock,
            $this->bridge->call($url, $this->transferMock),
        );
    }
}
