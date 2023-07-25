<?php

namespace FondOfImpala\Client\CompanyType\Dependency\Client;

use Codeception\Test\Unit;
use Spryker\Client\ZedRequest\ZedRequestClientInterface;
use Spryker\Shared\Kernel\Transfer\TransferInterface;

class CompanyTypeToZedRequestClientBridgeTest extends Unit
{
    /**
     * @var \FondOfImpala\Client\CompanyType\Dependency\Client\CompanyTypeToZedRequestClientBridge
     */
    protected $companyTypeToZedRequestClientBridge;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\ZedRequest\ZedRequestClientInterface
     */
    protected $zedRequestClientInterfaceMock;

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
        $this->zedRequestClientInterfaceMock = $this->getMockBuilder(ZedRequestClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->url = 'url';

        $this->transferInterfaceMock = $this->getMockBuilder(TransferInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyTypeToZedRequestClientBridge = new CompanyTypeToZedRequestClientBridge(
            $this->zedRequestClientInterfaceMock,
        );
    }

    /**
     * @return void
     */
    public function testCall(): void
    {
        $this->zedRequestClientInterfaceMock->expects($this->atLeastOnce())
            ->method('call')
            ->with(
                $this->url,
                $this->transferInterfaceMock,
            )->willReturn($this->transferInterfaceMock);

        $this->assertInstanceOf(
            TransferInterface::class,
            $this->companyTypeToZedRequestClientBridge->call(
                $this->url,
                $this->transferInterfaceMock,
            ),
        );
    }
}
