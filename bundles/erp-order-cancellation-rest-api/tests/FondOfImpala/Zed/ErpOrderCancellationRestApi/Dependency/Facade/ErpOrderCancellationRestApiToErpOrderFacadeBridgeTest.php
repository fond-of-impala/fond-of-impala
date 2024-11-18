<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Dependency\Facade;

use Codeception\Test\Unit;
use FondOfOryx\Zed\ErpOrder\Business\ErpOrderFacadeInterface;
use Generated\Shared\Transfer\ErpOrderTransfer;

class ErpOrderCancellationRestApiToErpOrderFacadeBridgeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ErpOrderCancellationRestApi\Dependency\Facade\ErpOrderCancellationRestApiToErpOrderFacadeBridge
     */
    protected ErpOrderCancellationRestApiToErpOrderFacadeBridge $bridge;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfOryx\Zed\ErpOrder\Business\ErpOrderFacadeInterface
     */
    protected MockObject|ErpOrderFacadeInterface $erpOrderFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ErpOrderTransfer
     */
    protected MockObject|ErpOrderTransfer $erpOrderTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->erpOrderFacadeMock = $this
            ->getMockBuilder(ErpOrderFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderTransferMock = $this
            ->getMockBuilder(ErpOrderTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bridge = new ErpOrderCancellationRestApiToErpOrderFacadeBridge(
            $this->erpOrderFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testFindErpOrderByReference(): void
    {
        $reference = 'reference';

        $this->erpOrderFacadeMock->expects(static::atLeastOnce())
            ->method('findErpOrderByReference')
            ->with($reference)
            ->willReturn($this->erpOrderTransferMock);

        $erpOrderTransfer = $this->bridge->findErpOrderByReference($reference);

        static::assertEquals($this->erpOrderTransferMock, $erpOrderTransfer);
    }

    /**
     * @return void
     */
    public function testFindErpOrderByExternalReference(): void
    {
        $reference = 'reference';

        $this->erpOrderFacadeMock->expects(static::atLeastOnce())
            ->method('findErpOrderByExternalReference')
            ->with($reference)
            ->willReturn($this->erpOrderTransferMock);

        $erpOrderTransfer = $this->bridge->findErpOrderByExternalReference($reference);

        static::assertEquals($this->erpOrderTransferMock, $erpOrderTransfer);
    }
}
