<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Dependency\Facade;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ErpOrderCancellation\Business\ErpOrderCancellationFacadeInterface;
use Generated\Shared\Transfer\ErpOrderCancellationResponseTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationTransfer;

class ErpOrderCancellationRestApiToErpOrderCancellationFacadeBridgeTest extends Unit
{
    /**
     * @var \FondOfImpala\Zed\ErpOrderCancellationRestApi\Dependency\Facade\ErpOrderCancellationRestApiToErpOrderCancellationFacadeBridge
     */
    protected ErpOrderCancellationRestApiToErpOrderCancellationFacadeBridge $bridge;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ErpOrderCancellation\Business\ErpOrderCancellationFacadeInterface
     */
    protected MockObject|ErpOrderCancellationFacadeInterface $erpOrderCancellationFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ErpOrderCancellationTransfer
     */
    protected MockObject|ErpOrderCancellationTransfer $erpOrderCancellationTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ErpOrderCancellationResponseTransfer
     */
    protected MockObject|ErpOrderCancellationResponseTransfer $erpOrderCancellationResponseTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->erpOrderCancellationFacadeMock = $this
            ->getMockBuilder(ErpOrderCancellationFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderCancellationTransferMock = $this
            ->getMockBuilder(ErpOrderCancellationTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderCancellationResponseTransferMock = $this
            ->getMockBuilder(ErpOrderCancellationResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bridge = new ErpOrderCancellationRestApiToErpOrderCancellationFacadeBridge(
            $this->erpOrderCancellationFacadeMock
        );
    }

    /**
     * @return void
     */
    public function testCreateErpOrderCancellation(): void
    {
        $this->erpOrderCancellationFacadeMock->expects(static::atLeastOnce())
            ->method('createErpOrderCancellation')
            ->with($this->erpOrderCancellationTransferMock)
            ->willReturn($this->erpOrderCancellationResponseTransferMock);

        $erpOrderCancellationresponseResponseTransfer = $this->bridge
            ->createErpOrderCancellation($this->erpOrderCancellationTransferMock);

        static::assertEquals(
            $this->erpOrderCancellationResponseTransferMock,
            $erpOrderCancellationresponseResponseTransfer
        );
    }

    /**
     * @return void
     */
    public function testUpdateErpOrderCancellation(): void
    {
        $this->erpOrderCancellationFacadeMock->expects(static::atLeastOnce())
            ->method('updateErpOrderCancellation')
            ->with($this->erpOrderCancellationTransferMock)
            ->willReturn($this->erpOrderCancellationResponseTransferMock);

        $erpOrderCancellationresponseResponseTransfer = $this->bridge
            ->updateErpOrderCancellation($this->erpOrderCancellationTransferMock);

        static::assertEquals(
            $this->erpOrderCancellationResponseTransferMock,
            $erpOrderCancellationresponseResponseTransfer
        );
    }

    /**
     * @return void
     */
    public function testDeleteErpOrderCancellationByIdErpOrderCancellation(): void
    {
        $idErpOrderCancellation = 1;

        $this->erpOrderCancellationFacadeMock->expects(static::atLeastOnce())
            ->method('deleteErpOrderCancellationByIdErpOrderCancellation')
            ->with($idErpOrderCancellation);

        $this->bridge
            ->deleteErpOrderCancellationByIdErpOrderCancellation($idErpOrderCancellation);

    }

}
