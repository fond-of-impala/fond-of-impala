<?php

namespace FondOfImpala\Client\CustomerPriceList\Dependency\Client;

use Codeception\Test\Unit;
use PHPUnit\Framework\MockObject\MockObject;
use Spryker\Client\ZedRequest\ZedRequestClientInterface;
use Spryker\Shared\Kernel\Transfer\TransferInterface;

class CustomerPriceListToZedRequestClientBridgeTest extends Unit
{
    /**
     * @var \FondOfImpala\Client\CustomerPriceList\Dependency\Client\CustomerPriceListToZedRequestClientBridge
     */
    protected CustomerPriceListToZedRequestClientBridge $customerPriceListToZedRequestClientBridge;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\ZedRequest\ZedRequestClientInterface
     */
    protected MockObject|ZedRequestClientInterface $zedRequestClientInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Shared\Kernel\Transfer\TransferInterface
     */
    protected MockObject|TransferInterface $transferInterfaceMock;

    /**
     * @var string
     */
    protected string $url;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->zedRequestClientInterfaceMock = $this->getMockBuilder(ZedRequestClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->transferInterfaceMock = $this->getMockBuilder(TransferInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->url = 'url';

        $this->customerPriceListToZedRequestClientBridge = new CustomerPriceListToZedRequestClientBridge(
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
            ->with($this->url, $this->transferInterfaceMock)
            ->willReturn($this->transferInterfaceMock);

        $this->assertEquals(
            $this->transferInterfaceMock,
            $this->customerPriceListToZedRequestClientBridge->call(
                $this->url,
                $this->transferInterfaceMock,
            ),
        );
    }
}
