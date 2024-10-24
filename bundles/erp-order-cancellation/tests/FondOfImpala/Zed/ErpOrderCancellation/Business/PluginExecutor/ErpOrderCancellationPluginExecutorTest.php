<?php

namespace FondOfImpala\Zed\ErpOrderCancellation\Business\PluginExecutor;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ErpOrderCancellationExtension\Dependency\Plugin\ErpOrderCancellationPostSavePluginInterface;
use FondOfImpala\Zed\ErpOrderCancellationExtension\Dependency\Plugin\ErpOrderCancellationPreSavePluginInterface;
use Generated\Shared\Transfer\ErpOrderCancellationTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ErpOrderCancellationPluginExecutorTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ErpOrderCancellationExtension\Dependency\Plugin\ErpOrderCancellationPostSavePluginInterface
     */
    protected MockObject|ErpOrderCancellationPostSavePluginInterface $erpOrderCancellationPostSavePluginMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ErpOrderCancellationExtension\Dependency\Plugin\ErpOrderCancellationPreSavePluginInterface
     */
    protected MockObject|ErpOrderCancellationPreSavePluginInterface $erpOrderCancellationPreSavePluginMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ErpOrderCancellationTransfer
     */
    protected MockObject|ErpOrderCancellationTransfer $erpOrderCancellationTransferMock;

    /**
     * @var \FondOfImpala\Zed\ErpOrderCancellation\Business\PluginExecutor\ErpOrderCancellationPluginExecutorInterface
     */
    protected ErpOrderCancellationPluginExecutorInterface $pluginExecutor;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->erpOrderCancellationPostSavePluginMock = $this
            ->getMockBuilder(ErpOrderCancellationPostSavePluginInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderCancellationPreSavePluginMock = $this
            ->getMockBuilder(ErpOrderCancellationPreSavePluginInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderCancellationTransferMock = $this
            ->getMockBuilder(ErpOrderCancellationTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $erpOrderCancellationPreSavePlugins = [$this->erpOrderCancellationPreSavePluginMock];
        $erpOrderCancellationPostSavePlugins = [$this->erpOrderCancellationPostSavePluginMock];
        $erpOrderCancellationPostTransactionPlugins = [];

        $this->pluginExecutor = new ErpOrderCancellationPluginExecutor(
            $erpOrderCancellationPreSavePlugins,
            $erpOrderCancellationPostSavePlugins,
            $erpOrderCancellationPostTransactionPlugins,
        );
    }

    /**
     * @return void
     */
    public function testExecutePostSavePlugins(): void
    {
        $this->erpOrderCancellationPostSavePluginMock->expects(static::atLeastOnce())
            ->method('postSave')
            ->with($this->erpOrderCancellationTransferMock)
            ->willReturn($this->erpOrderCancellationTransferMock);

        static::assertInstanceOf(
            ErpOrderCancellationTransfer::class,
            $this->pluginExecutor->executePostSavePlugins($this->erpOrderCancellationTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testExecutePreSavePlugins(): void
    {
        $this->erpOrderCancellationPreSavePluginMock->expects(static::atLeastOnce())
            ->method('preSave')
            ->with($this->erpOrderCancellationTransferMock)
            ->willReturn($this->erpOrderCancellationTransferMock);

        static::assertInstanceOf(
            ErpOrderCancellationTransfer::class,
            $this->pluginExecutor->executePreSavePlugins($this->erpOrderCancellationTransferMock),
        );
    }
}
