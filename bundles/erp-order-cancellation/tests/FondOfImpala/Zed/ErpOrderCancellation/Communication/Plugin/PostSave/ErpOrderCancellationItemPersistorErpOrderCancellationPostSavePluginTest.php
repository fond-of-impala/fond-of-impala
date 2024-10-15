<?php

namespace FondOfImpala\Zed\ErpOrderCancellation\Communication\Plugin\PostSave;

use Codeception\Test\Unit;
use FondOfImpala\Zed\ErpOrderCancellation\Business\ErpOrderCancellationFacade;
use Generated\Shared\Transfer\ErpOrderCancellationTransfer;

class ErpOrderCancellationItemPersistorErpOrderCancellationPostSavePluginTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ErpOrderCancellationTransfer
     */
    protected MockObject|ErpOrderCancellationTransfer $erpOrderCancellationTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ErpOrderCancellation\Business\ErpOrderCancellationFacade
     */
    protected MockObject|ErpOrderCancellationFacade $facadeMock;

    /**
     * @var \FondOfImpala\Zed\ErpOrderCancellation\Communication\Plugin\PostSave\ErpOrderCancellationItemPersistorErpOrderCancellationPostSavePlugin
     */
    protected ErpOrderCancellationItemPersistorErpOrderCancellationPostSavePlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->erpOrderCancellationTransferMock = $this->getMockBuilder(ErpOrderCancellationTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->facadeMock = $this->getMockBuilder(ErpOrderCancellationFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new ErpOrderCancellationItemPersistorErpOrderCancellationPostSavePlugin();
        $this->plugin->setFacade($this->facadeMock);
    }

    /**
     * @return void
     */
    public function testPostSave(): void
    {
        $this->facadeMock->expects(static::atLeastOnce())
            ->method('persistErpOrderCancellationItem')
            ->with($this->erpOrderCancellationTransferMock)
            ->willReturn($this->erpOrderCancellationTransferMock);

        static::assertInstanceOf(
            ErpOrderCancellationTransfer::class,
            $this->plugin->postSave($this->erpOrderCancellationTransferMock),
        );
    }
}
