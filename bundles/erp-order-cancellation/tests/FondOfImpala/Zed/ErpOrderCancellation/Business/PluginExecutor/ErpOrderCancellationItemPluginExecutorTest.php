<?php

namespace FondOfImpala\Zed\ErpOrderCancellation\Business\PluginExecutor;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ErpOrderCancellationExtension\Dependency\Plugin\ErpOrderCancellationItemPostSavePluginInterface;
use FondOfImpala\Zed\ErpOrderCancellationExtension\Dependency\Plugin\ErpOrderCancellationItemPreSavePluginInterface;
use Generated\Shared\Transfer\ErpOrderCancellationItemTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class ErpOrderCancellationItemPluginExecutorTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ErpOrderCancellationExtension\Dependency\Plugin\ErpOrderCancellationItemPostSavePluginInterface
     */
    protected MockObject|ErpOrderCancellationItemPostSavePluginInterface $erpOrderCancellationItemPostSavePluginMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ErpOrderCancellationExtension\Dependency\Plugin\ErpOrderCancellationItemPreSavePluginInterface
     */
    protected MockObject|ErpOrderCancellationItemPreSavePluginInterface $erpOrderCancellationItemPreSavePluginMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ErpOrderCancellationItemTransfer
     */
    protected MockObject|ErpOrderCancellationItemTransfer $erpOrderCancellationItemTransferMock;

    /**
     * @var \FondOfImpala\Zed\ErpOrderCancellation\Business\PluginExecutor\ErpOrderCancellationItemPluginExecutorInterface
     */
    protected ErpOrderCancellationItemPluginExecutorInterface $pluginExecutor;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->erpOrderCancellationItemPostSavePluginMock = $this
            ->getMockBuilder(ErpOrderCancellationItemPostSavePluginInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderCancellationItemPreSavePluginMock = $this
            ->getMockBuilder(ErpOrderCancellationItemPreSavePluginInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderCancellationItemTransferMock = $this
            ->getMockBuilder(ErpOrderCancellationItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $erpOrderCancellationItemPreSavePlugins = [$this->erpOrderCancellationItemPreSavePluginMock];
        $erpOrderCancellationItemPostSavePlugins = [$this->erpOrderCancellationItemPostSavePluginMock];

        $this->pluginExecutor = new ErpOrderCancellationItemPluginExecutor(
            $erpOrderCancellationItemPreSavePlugins,
            $erpOrderCancellationItemPostSavePlugins,
        );
    }

    /**
     * @return void
     */
    public function testExecutePostSavePlugins(): void
    {
        $this->erpOrderCancellationItemPostSavePluginMock->expects(static::atLeastOnce())
            ->method('postSave')
            ->with($this->erpOrderCancellationItemTransferMock)
            ->willReturn($this->erpOrderCancellationItemTransferMock);

        static::assertInstanceOf(
            ErpOrderCancellationItemTransfer::class,
            $this->pluginExecutor->executePostSavePlugins($this->erpOrderCancellationItemTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testExecutePreSavePlugins(): void
    {
        $this->erpOrderCancellationItemPreSavePluginMock->expects(static::atLeastOnce())
            ->method('preSave')
            ->with($this->erpOrderCancellationItemTransferMock)
            ->willReturn($this->erpOrderCancellationItemTransferMock);

        static::assertInstanceOf(
            ErpOrderCancellationItemTransfer::class,
            $this->pluginExecutor->executePreSavePlugins($this->erpOrderCancellationItemTransferMock),
        );
    }
}
