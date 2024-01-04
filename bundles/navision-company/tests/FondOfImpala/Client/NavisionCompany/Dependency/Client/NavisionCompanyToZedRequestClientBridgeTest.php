<?php

namespace FondOfImpala\Client\NavisionCompany\Dependency\Client;

use Codeception\Test\Unit;
use Spryker\Client\ZedRequest\ZedRequestClient;
use Spryker\Shared\Kernel\Transfer\TransferInterface;

class NavisionCompanyToZedRequestClientBridgeTest extends Unit
{
    /**
     * @var \FondOfImpala\Client\NavisionCompany\Dependency\Client\NavisionCompanyToZedRequestClientBridge
     */
    protected $navisionCompanyToZedRequestClientBridge;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\ZedRequest\ZedRequestClient
     */
    protected $zedRequestClientMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Shared\Kernel\Transfer\TransferInterface
     */
    protected $transferInterfaceMock;

    /**
     * @var string
     */
    protected $url;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->zedRequestClientMock = $this->getMockBuilder(ZedRequestClient::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->transferInterfaceMock = $this->getMockBuilder(TransferInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->url = 'test url';

        $this->navisionCompanyToZedRequestClientBridge = new NavisionCompanyToZedRequestClientBridge($this->zedRequestClientMock);
    }

    /**
     * @return void
     */
    public function testCall(): void
    {
        $this->zedRequestClientMock->expects($this->atLeastOnce())
            ->method('call')
            ->willReturn($this->transferInterfaceMock);

        $this->assertInstanceOf(TransferInterface::class, $this->navisionCompanyToZedRequestClientBridge->call($this->url, $this->transferInterfaceMock));
    }
}
