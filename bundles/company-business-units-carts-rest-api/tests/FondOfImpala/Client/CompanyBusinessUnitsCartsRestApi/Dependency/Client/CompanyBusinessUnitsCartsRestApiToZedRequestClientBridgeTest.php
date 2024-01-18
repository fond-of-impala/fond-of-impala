<?php

namespace FondOfImpala\Client\CompanyBusinessUnitsCartsRestApi\Dependency\Client;

use Codeception\Test\Unit;
use Spryker\Client\ZedRequest\ZedRequestClientInterface;
use Spryker\Shared\Kernel\Transfer\TransferInterface;

class CompanyBusinessUnitsCartsRestApiToZedRequestClientBridgeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\ZedRequest\ZedRequestClientInterface
     */
    protected $zedRequestClientMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Shared\Kernel\Transfer\TransferInterface
     */
    protected $transferMock;

    /**
     * @var \FondOfImpala\Client\CompanyBusinessUnitsCartsRestApi\Dependency\Client\CompanyBusinessUnitsCartsRestApiToZedRequestClientBridge
     */
    protected $companyBusinessUnitsCartsRestApiToZedRequestClientBridge;

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

        $this->companyBusinessUnitsCartsRestApiToZedRequestClientBridge = new CompanyBusinessUnitsCartsRestApiToZedRequestClientBridge($this->zedRequestClientMock);
    }

    /**
     * @return void
     */
    public function testCall(): void
    {
        $url = '...';

        $this->zedRequestClientMock->expects(self::atLeastOnce())
            ->method('call')
            ->with($url, $this->transferMock)
            ->willReturn($this->transferMock);

        $transfer = $this->companyBusinessUnitsCartsRestApiToZedRequestClientBridge->call($url, $this->transferMock);

        self::assertEquals($this->transferMock, $transfer);
    }
}
