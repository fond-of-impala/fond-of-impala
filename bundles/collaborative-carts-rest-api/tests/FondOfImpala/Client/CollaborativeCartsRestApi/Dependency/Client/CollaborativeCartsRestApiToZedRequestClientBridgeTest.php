<?php

namespace FondOfImpala\Client\CollaborativeCartsRestApi\Dependency\Client;

use Codeception\Test\Unit;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Client\ZedRequest\ZedRequestClientInterface;
use Spryker\Shared\Kernel\Transfer\TransferInterface;

class CollaborativeCartsRestApiToZedRequestClientBridgeTest extends Unit
{
    protected MockObject|ZedRequestClientInterface $zedRequestClientMock;

    protected MockObject|TransferInterface $transferMock;

    protected CollaborativeCartsRestApiToZedRequestClientBridge $collaborativeCartsRestApiToZedRequestClientBridge;

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

        $this->collaborativeCartsRestApiToZedRequestClientBridge =
            new CollaborativeCartsRestApiToZedRequestClientBridge($this->zedRequestClientMock);
    }

    /**
     * @return void
     */
    public function testCall(): void
    {
        $url = '';

        $this->zedRequestClientMock->expects(static::atLeastOnce())
            ->method('call')
            ->with($url, $this->transferMock)
            ->willReturn($this->transferMock);

        $transfer = $this->collaborativeCartsRestApiToZedRequestClientBridge->call($url, $this->transferMock);

        $this->assertEquals($this->transferMock, $transfer);
    }
}
