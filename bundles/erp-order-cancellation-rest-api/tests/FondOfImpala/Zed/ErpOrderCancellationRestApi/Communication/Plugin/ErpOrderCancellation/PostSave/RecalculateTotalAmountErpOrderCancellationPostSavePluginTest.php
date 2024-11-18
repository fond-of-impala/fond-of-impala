<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Communication\Plugin\ErpOrderCancellation\PostSave;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\ErpOrderCancellationRestApiFacade;
use Generated\Shared\Transfer\ErpOrderCancellationItemTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class RecalculateTotalAmountErpOrderCancellationPostSavePluginTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ErpOrderCancellationTransfer
     */
    protected MockObject|ErpOrderCancellationTransfer $erpOrderCancellationTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ErpOrderCancellationItemTransfer
     */
    protected MockObject|ErpOrderCancellationItemTransfer $erpOrderCancellationItemTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\ErpOrderCancellationRestApiFacade
     */
    protected MockObject|ErpOrderCancellationRestApiFacade $facadeMock;

    /**
     * @var \FondOfImpala\Zed\ErpOrderCancellationRestApi\Communication\Plugin\ErpOrderCancellation\PostSave\RecalculateTotalAmountErpOrderCancellationPostSavePlugin
     */
    protected RecalculateTotalAmountErpOrderCancellationPostSavePlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->erpOrderCancellationTransferMock = $this
            ->getMockBuilder(ErpOrderCancellationTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderCancellationItemTransferMock = $this
            ->getMockBuilder(ErpOrderCancellationItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->facadeMock = $this
            ->getMockBuilder(ErpOrderCancellationRestApiFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new RecalculateTotalAmountErpOrderCancellationPostSavePlugin();
        $this->plugin->setFacade($this->facadeMock);
    }

    /**
     * @return void
     */
    public function testPostSave(): void
    {
        $item2 = clone $this->erpOrderCancellationItemTransferMock;
        $itemCollection = new ArrayObject([
            $this->erpOrderCancellationItemTransferMock,
            $item2,
        ]);

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('getCancellationItems')
            ->willReturn($itemCollection);

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('getAmount')
            ->willReturn(10);

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('setAmount')
            ->with(15)
            ->willReturnSelf();

        $this->erpOrderCancellationItemTransferMock->expects(static::atLeastOnce())
            ->method('getCancellationValue')
            ->willReturn(10);

        $item2->expects(static::atLeastOnce())
            ->method('getCancellationValue')
            ->willReturn(5);

        $this->facadeMock->expects(static::atLeastOnce())
            ->method('updateErpOrderCancellationAmount')
            ->willReturn($this->erpOrderCancellationTransferMock);

        $this->plugin->postSave($this->erpOrderCancellationTransferMock);
    }

    /**
     * @return void
     */
    public function testPostSaveWithNoUpdate(): void
    {
        $item2 = clone $this->erpOrderCancellationItemTransferMock;
        $itemCollection = new ArrayObject([
            $this->erpOrderCancellationItemTransferMock,
            $item2,
        ]);

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('getCancellationItems')
            ->willReturn($itemCollection);

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('getAmount')
            ->willReturn(15);

        $this->erpOrderCancellationTransferMock->expects(static::never())
            ->method('setAmount');

        $this->erpOrderCancellationItemTransferMock->expects(static::atLeastOnce())
            ->method('getCancellationValue')
            ->willReturn(10);

        $item2->expects(static::atLeastOnce())
            ->method('getCancellationValue')
            ->willReturn(5);

        $this->facadeMock->expects(static::never())
            ->method('updateErpOrderCancellationAmount');

        $this->plugin->postSave($this->erpOrderCancellationTransferMock);
    }
}
