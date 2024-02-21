<?php

namespace FondOfImpala\Client\OrderBudgetsBulkRestApi\Dependency\Client;

use Codeception\Test\Unit;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Client\ZedRequest\ZedRequestClientInterface;
use Spryker\Shared\Kernel\Transfer\TransferInterface;

class OrderBudgetsBulkRestApiToZedRequestClientBridgeTest extends Unit
{
    protected MockObject|ZedRequestClientInterface $clientMock;

    protected MockObject|TransferInterface $transferMock;

    protected OrderBudgetsBulkRestApiToZedRequestClientBridge $bridge;

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

        $this->bridge = new OrderBudgetsBulkRestApiToZedRequestClientBridge(
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
