<?php

namespace FondOfImpala\Zed\ErpOrderCancellation\Business\Handler;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfImpala\Zed\ErpOrderCancellation\Business\Model\Reader\ErpOrderCancellationItemReaderInterface;
use FondOfImpala\Zed\ErpOrderCancellation\Business\Model\Writer\ErpOrderCancellationItemWriterInterface;
use Generated\Shared\Transfer\ErpOrderCancellationItemTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ErpOrderCancellationItemHandlerTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ErpOrderCancellation\Business\Model\Reader\ErpOrderCancellationItemReaderInterface
     */
    protected MockObject|ErpOrderCancellationItemPostSavePluginInterface $erpOrderCancellationItemReaderMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ErpOrderCancellation\Business\Model\Writer\ErpOrderCancellationItemWriterInterface
     */
    protected MockObject|ErpOrderCancellationItemPreSavePluginInterface $erpOrderCancellationItemWriterMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ErpOrderCancellationTransfer
     */
    protected MockObject|ErpOrderCancellationTransfer $erpOrderCancellationTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ErpOrderCancellationItemTransfer
     */
    protected MockObject|ErpOrderCancellationItemTransfer $erpOrderCancellationItemTransferMock;

    /**
     * @var \FondOfImpala\Zed\ErpOrderCancellation\Business\Handler\ErpOrderCancellationItemHandlerInterface
     */
    protected ErpOrderCancellationItemHandlerInterface $handler;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->erpOrderCancellationItemReaderMock = $this
            ->getMockBuilder(ErpOrderCancellationItemReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderCancellationItemWriterMock = $this
            ->getMockBuilder(ErpOrderCancellationItemWriterInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderCancellationItemTransferMock = $this
            ->getMockBuilder(ErpOrderCancellationItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderCancellationTransferMock = $this
            ->getMockBuilder(ErpOrderCancellationTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->handler = new ErpOrderCancellationItemHandler(
            $this->erpOrderCancellationItemWriterMock,
            $this->erpOrderCancellationItemReaderMock,
        );
    }

    /**
     * @return void
     */
    public function testHandleUpdate(): void
    {
        $idErpOrderCancellation = 1;
        $fkErpOrderCancellation = 1;
        $createdAt = '1970-01-01';
        $sku = 'sku';

        $existingErpOrderCancellationItems = new ArrayObject();
        $existingErpOrderCancellationItems->append($this->erpOrderCancellationItemTransferMock);

        $cancellationItems = new ArrayObject();
        $cancellationItems->append($this->erpOrderCancellationItemTransferMock);

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('requireIdErpOrderCancellation')
            ->willReturnSelf();

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('getIdErpOrderCancellation')
            ->willReturn($idErpOrderCancellation);

        $this->erpOrderCancellationItemReaderMock->expects(static::atLeastOnce())
            ->method('findErpOrderCancellationItemsByIdErpOrderCancellation')
            ->with($idErpOrderCancellation)
            ->willReturn($existingErpOrderCancellationItems);

        $this->erpOrderCancellationItemTransferMock->expects(static::atLeastOnce())
            ->method('getSku')
            ->willReturn($sku);

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('getCancellationItems')
            ->willReturn($cancellationItems);

        $this->erpOrderCancellationItemTransferMock->expects(static::atLeastOnce())
            ->method('getFkErpOrderCancellation')
            ->willReturn($fkErpOrderCancellation);

        $this->erpOrderCancellationItemTransferMock->expects(static::atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $this->erpOrderCancellationItemTransferMock->expects(static::atLeastOnce())
            ->method('fromArray')
            ->willReturnSelf();

        $this->erpOrderCancellationItemTransferMock->expects(static::atLeastOnce())
            ->method('setFkErpOrderCancellation')
            ->willReturnSelf();

        $this->erpOrderCancellationItemTransferMock->expects(static::atLeastOnce())
            ->method('getCancellationQuantity')
            ->willReturn(1);

        $this->erpOrderCancellationItemTransferMock->expects(static::atLeastOnce())
            ->method('requireFkErpOrderCancellation')
            ->willReturnSelf();

        $this->erpOrderCancellationItemTransferMock->expects(static::atLeastOnce())
            ->method('requireSku')
            ->willReturnSelf();

        $this->erpOrderCancellationItemTransferMock->expects(static::atLeastOnce())
            ->method('getFkErpOrderCancellation')
            ->willReturn($fkErpOrderCancellation);

        $this->erpOrderCancellationItemTransferMock->expects(static::atLeastOnce())
            ->method('getSku')
            ->willReturn($sku);

        $this->erpOrderCancellationItemReaderMock->expects(static::atLeastOnce())
            ->method('findErpOrderCancellationItemByIdErpOrderCancellationAndSku')
            ->with($fkErpOrderCancellation, $sku)
            ->willReturn($this->erpOrderCancellationItemTransferMock);

        $this->erpOrderCancellationItemTransferMock->expects(static::atLeastOnce())
            ->method('getCreatedAt')
            ->willReturn($createdAt);

        $this->erpOrderCancellationItemTransferMock->expects(static::atLeastOnce())
            ->method('setCreatedAt')
            ->with($createdAt)
            ->willReturnSelf();

        $this->erpOrderCancellationItemTransferMock->expects(static::atLeastOnce())
            ->method('setUpdatedAt')
            ->willReturnSelf();

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('setCancellationItems')
            ->willReturn($this->erpOrderCancellationTransferMock);

        $response = $this->handler->handle($this->erpOrderCancellationTransferMock);

        static::assertEquals($this->erpOrderCancellationTransferMock, $response);
        static::assertEquals(1, $response->getCancellationItems()->count());
    }

    /**
     * @return void
     */
    public function testHandleDelete(): void
    {
        $idErpOrderCancellation = 1;
        $fkErpOrderCancellation = 1;
        $sku = 'sku';

        $cancellationItems = new ArrayObject();
        $cancellationItems->append($this->erpOrderCancellationItemTransferMock);

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('requireIdErpOrderCancellation')
            ->willReturnSelf();

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('getIdErpOrderCancellation')
            ->willReturn($idErpOrderCancellation);

        $this->erpOrderCancellationItemReaderMock->expects(static::atLeastOnce())
            ->method('findErpOrderCancellationItemsByIdErpOrderCancellation')
            ->with($idErpOrderCancellation)
            ->willReturn($cancellationItems);

        $this->erpOrderCancellationItemTransferMock->expects(static::atLeastOnce())
            ->method('getSku')
            ->willReturn($sku);

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('getCancellationItems')
            ->willReturn($cancellationItems);

        $this->erpOrderCancellationItemTransferMock->expects(static::atLeastOnce())
            ->method('getFkErpOrderCancellation')
            ->willReturn($fkErpOrderCancellation);

        $this->erpOrderCancellationItemTransferMock->expects(static::atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $this->erpOrderCancellationItemTransferMock->expects(static::atLeastOnce())
            ->method('fromArray')
            ->willReturnSelf();

        $this->erpOrderCancellationItemTransferMock->expects(static::atLeastOnce())
            ->method('setFkErpOrderCancellation')
            ->willReturnSelf();

        $this->erpOrderCancellationItemTransferMock->expects(static::atLeastOnce())
            ->method('getCancellationQuantity')
            ->willReturn(0);

        $this->erpOrderCancellationItemTransferMock->expects(static::atLeastOnce())
            ->method('getFkErpOrderCancellationOrFail')
            ->willReturn($fkErpOrderCancellation);

        $this->erpOrderCancellationItemWriterMock->expects(static::atLeastOnce())
            ->method('delete')
            ->with($fkErpOrderCancellation, $sku)
            ->willReturnSelf();

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('setCancellationItems')
            ->willReturn($this->erpOrderCancellationTransferMock);

        $response = $this->handler->handle($this->erpOrderCancellationTransferMock);

        static::assertEquals($this->erpOrderCancellationTransferMock, $response);
    }

    /**
     * @return void
     */
    public function testHandleCreate(): void
    {
        $idErpOrderCancellation = 1;
        $fkErpOrderCancellation = 1;
        $sku = 'sku';
        $newSku = 'new-sku';

        $cancellationItems = new ArrayObject();
        $cancellationItems->append($this->erpOrderCancellationItemTransferMock);

        $existingErpOrderCancellationItemTransferMock = clone $this->erpOrderCancellationItemTransferMock;
        $existingCancellationItems = new ArrayObject();
        $existingCancellationItems->append($existingErpOrderCancellationItemTransferMock);

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('requireIdErpOrderCancellation')
            ->willReturnSelf();

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('getIdErpOrderCancellation')
            ->willReturn($idErpOrderCancellation);

        $this->erpOrderCancellationItemReaderMock->expects(static::atLeastOnce())
            ->method('findErpOrderCancellationItemsByIdErpOrderCancellation')
            ->with($idErpOrderCancellation)
            ->willReturn($existingCancellationItems);

        $existingErpOrderCancellationItemTransferMock->expects(static::atLeastOnce())
            ->method('getSku')
            ->willReturn($newSku);

        $existingErpOrderCancellationItemTransferMock->expects(static::atLeastOnce())
            ->method('getFkErpOrderCancellation')
            ->willReturn($fkErpOrderCancellation);

        $this->erpOrderCancellationItemTransferMock->expects(static::atLeastOnce())
            ->method('getSku')
            ->willReturn($sku);

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('getCancellationItems')
            ->willReturn($cancellationItems);

        $this->erpOrderCancellationItemTransferMock->expects(static::atLeastOnce())
            ->method('getFkErpOrderCancellation')
            ->willReturn($fkErpOrderCancellation);

        $this->erpOrderCancellationItemTransferMock->expects(static::atLeastOnce())
            ->method('setFkErpOrderCancellation')
            ->willReturnSelf();

        $this->erpOrderCancellationItemTransferMock->expects(static::atLeastOnce())
            ->method('getCancellationQuantity')
            ->willReturn(1);

        $this->erpOrderCancellationItemWriterMock->expects(static::atLeastOnce())
            ->method('create')
            ->with($this->erpOrderCancellationItemTransferMock)
            ->willReturn($this->erpOrderCancellationItemTransferMock);

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('setCancellationItems')
            ->willReturn($this->erpOrderCancellationTransferMock);

        $response = $this->handler->handle($this->erpOrderCancellationTransferMock);

        static::assertEquals($this->erpOrderCancellationTransferMock, $response);
        static::assertEquals(1, $response->getCancellationItems()->count());
    }
}
