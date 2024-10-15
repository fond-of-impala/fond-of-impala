<?php

namespace FondOfImpala\Zed\ErpOrderCancellation\Business\Model\Writer;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ErpOrderCancellation\Business\PluginExecutor\ErpOrderCancellationItemPluginExecutorInterface;
use FondOfImpala\Zed\ErpOrderCancellation\Persistence\ErpOrderCancellationEntityManagerInterface;
use Generated\Shared\Transfer\ErpOrderCancellationItemTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ErpOrderCancellationItemWriterTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ErpOrderCancellation\Business\PluginExecutor\ErpOrderCancellationPluginExecutorInterface
     */
    protected MockObject|ErpOrderCancellationItemPluginExecutorInterface $erpOrderCancellationItemPluginExecutorMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ErpOrderCancellationItemTransfer
     */
    protected MockObject|ErpOrderCancellationItemTransfer $erpOrderCancellationItemTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ErpOrderCancellation\Persistence\ErpOrderCancellationEntityManagerInterface
     */
    protected MockObject|ErpOrderCancellationEntityManagerInterface $entityManagerMock;

    /**
     * @var \FondOfImpala\Zed\ErpOrderCancellation\Business\Model\Writer\ErpOrderCancellationItemWriterInterface
     */
    protected ErpOrderCancellationItemWriterInterface $writer;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->entityManagerMock = $this
            ->getMockBuilder(ErpOrderCancellationEntityManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderCancellationItemTransferMock = $this
            ->getMockBuilder(ErpOrderCancellationItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderCancellationItemPluginExecutorMock = $this
            ->getMockBuilder(ErpOrderCancellationItemPluginExecutorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->writer = new ErpOrderCancellationItemWriter(
            $this->entityManagerMock,
            $this->erpOrderCancellationItemPluginExecutorMock,
        );
    }

    /**
     * @return void
     */
    public function testCreate(): void
    {
        $this->erpOrderCancellationItemPluginExecutorMock->expects(static::atLeastOnce())
            ->method('executePreSavePlugins')
            ->with($this->erpOrderCancellationItemTransferMock)
            ->willReturn($this->erpOrderCancellationItemTransferMock);

        $this->entityManagerMock->expects(static::atLeastOnce())
            ->method('createErpOrderCancellationItem')
            ->with($this->erpOrderCancellationItemTransferMock)
            ->willReturn($this->erpOrderCancellationItemTransferMock);

        $this->erpOrderCancellationItemPluginExecutorMock->expects(static::atLeastOnce())
            ->method('executePostSavePlugins')
            ->with($this->erpOrderCancellationItemTransferMock)
            ->willReturn($this->erpOrderCancellationItemTransferMock);

        $response = $this->writer->create($this->erpOrderCancellationItemTransferMock);

        static::assertEquals($this->erpOrderCancellationItemTransferMock, $response);
    }

    /**
     * @return void
     */
    public function testUpdate(): void
    {
        $this->erpOrderCancellationItemTransferMock->expects(static::atLeastOnce())
            ->method('requireFkErpOrderCancellation')
            ->willReturnSelf();

        $this->erpOrderCancellationItemTransferMock->expects(static::atLeastOnce())
            ->method('requireSku')
            ->willReturnSelf();

        $this->erpOrderCancellationItemPluginExecutorMock->expects(static::atLeastOnce())
            ->method('executePreSavePlugins')
            ->with($this->erpOrderCancellationItemTransferMock)
            ->willReturn($this->erpOrderCancellationItemTransferMock);

        $this->entityManagerMock->expects(static::atLeastOnce())
            ->method('updateErpOrderCancellationItem')
            ->with($this->erpOrderCancellationItemTransferMock)
            ->willReturn($this->erpOrderCancellationItemTransferMock);

        $this->erpOrderCancellationItemPluginExecutorMock->expects(static::atLeastOnce())
            ->method('executePostSavePlugins')
            ->with($this->erpOrderCancellationItemTransferMock)
            ->willReturn($this->erpOrderCancellationItemTransferMock);

        $response = $this->writer->update($this->erpOrderCancellationItemTransferMock);

        static::assertEquals($this->erpOrderCancellationItemTransferMock, $response);
    }

    /**
     * @return void
     */
    public function testDelete(): void
    {
        $fkErpOrderCancellation = 1;
        $sku = 'sku';

        $this->entityManagerMock->expects(static::atLeastOnce())
            ->method('deleteErpOrderCancellationItemByIdErpOrderCancellationItem')
            ->with($fkErpOrderCancellation);

        $this->writer->delete($fkErpOrderCancellation, $sku);
    }
}
