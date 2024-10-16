<?php

namespace FondOfImpala\Zed\ErpOrderCancellation\Communication\Plugin\PostSave;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ErpOrderCancellation\Communication\Plugin\PreSave\GenerateCancellationReferenceErpOrderCancellationPreSavePlugin;
use FondOfImpala\Zed\ErpOrderCancellation\ErpOrderCancellationConfig;
use Generated\Shared\Transfer\ErpOrderCancellationTransfer;

class GenerateCancellationReferenceErpOrderCancellationPreSavePluginTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ErpOrderCancellationTransfer
     */
    protected MockObject|ErpOrderCancellationTransfer $erpOrderCancellationTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ErpOrderCancellation\ErpOrderCancellationConfig
     */
    protected MockObject|ErpOrderCancellationConfig $configMock;

    /**
     * @var \FondOfImpala\Zed\ErpOrderCancellation\Communication\Plugin\PreSave\GenerateCancellationReferenceErpOrderCancellationPreSavePlugin
     */
    protected GenerateCancellationReferenceErpOrderCancellationPreSavePlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->erpOrderCancellationTransferMock = $this->getMockBuilder(ErpOrderCancellationTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderCancellationConfigMock = $this->getMockBuilder(ErpOrderCancellationConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new GenerateCancellationReferenceErpOrderCancellationPreSavePlugin();
        $this->plugin->setConfig($this->erpOrderCancellationConfigMock);
    }

    /**
     * @return void
     */
    public function testPreSave(): void
    {
        $prefixToReplace = 'prefixToReplace';
        $reference = $prefixToReplace . 'reference';
        $prefix = 'prefix';

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('getErpOrderReference')
            ->willReturn($reference);

        $this->erpOrderCancellationConfigMock->expects(static::atLeastOnce())
            ->method('getPrefixToReplace')
            ->willReturn($prefixToReplace);

        $this->erpOrderCancellationConfigMock->expects(static::atLeastOnce())
            ->method('getPrefix')
            ->willReturn($prefix);

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('setCancellationNumber')
            ->with('prefixreference')
            ->willReturn($this->erpOrderCancellationTransferMock);

        static::assertInstanceOf(
            ErpOrderCancellationTransfer::class,
            $this->plugin->preSave($this->erpOrderCancellationTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testPreSaveWithNullReference(): void
    {
        $reference = null;

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('getErpOrderReference')
            ->willReturn($reference);

        static::assertInstanceOf(
            ErpOrderCancellationTransfer::class,
            $this->plugin->preSave($this->erpOrderCancellationTransferMock),
        );
    }
}
