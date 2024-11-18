<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Communication\Plugin\ErpOrderCancellation\PreSave;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfImpala\Zed\ErpOrderCancellationRestApi\Communication\ErpOrderCancellationRestApiCommunicationFactory;
use FondOfImpala\Zed\ErpOrderCancellationRestApi\Dependency\Facade\ErpOrderCancellationRestApiToErpOrderFacadeInterface;
use Generated\Shared\Transfer\ErpOrderAmountTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationItemTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationTransfer;
use Generated\Shared\Transfer\ErpOrderItemTransfer;
use Generated\Shared\Transfer\ErpOrderTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class CancellationCalculationsErpOrderCancellationPreSavePluginTest extends Unit
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
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ErpOrderTransfer
     */
    protected MockObject|ErpOrderTransfer $erpOrderTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ErpOrderItemTransfer
     */
    protected MockObject|ErpOrderItemTransfer $erpOrderItemTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ErpOrderAmountTransfer
     */
    protected MockObject|ErpOrderAmountTransfer $erpOrderAmountTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ErpOrderCancellationRestApi\Communication\ErpOrderCancellationRestApiCommunicationFactory
     */
    protected MockObject|ErpOrderCancellationRestApiCommunicationFactory $factoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfImpala\Zed\ErpOrderCancellationRestApi\Dependency\Facade\ErpOrderCancellationRestApiToErpOrderFacadeInterface
     */
    protected MockObject|ErpOrderCancellationRestApiToErpOrderFacadeInterface $erpOrderFacadeMock;

    /**
     * @var \FondOfImpala\Zed\ErpOrderCancellationRestApi\Communication\Plugin\ErpOrderCancellation\PreSave\CancellationCalculationsErpOrderCancellationPreSavePlugin
     */
    protected CancellationCalculationsErpOrderCancellationPreSavePlugin $plugin;

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

        $this->factoryMock = $this
            ->getMockBuilder(ErpOrderCancellationRestApiCommunicationFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderFacadeMock = $this
            ->getMockBuilder(ErpOrderCancellationRestApiToErpOrderFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderTransferMock = $this
            ->getMockBuilder(ErpOrderTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderItemTransferMock = $this
            ->getMockBuilder(ErpOrderItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->erpOrderAmountTransferMock = $this
            ->getMockBuilder(ErpOrderAmountTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new CancellationCalculationsErpOrderCancellationPreSavePlugin();
        $this->plugin->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testPreSave(): void
    {
        $itemCollection = new ArrayObject([
            $this->erpOrderCancellationItemTransferMock,
        ]);

        $erpOrderItemCollection = new ArrayObject([
            $this->erpOrderItemTransferMock,
        ]);

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('getCancellationItems')
            ->willReturn($itemCollection);

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('getErpOrderReference')
            ->willReturn('erpOrderReference');

        $this->factoryMock->expects(static::atLeastOnce())
            ->method('getErpOrderFacade')
            ->willReturn($this->erpOrderFacadeMock);

        $this->erpOrderFacadeMock->expects(static::atLeastOnce())
            ->method('findErpOrderByReference')
            ->willReturn($this->erpOrderTransferMock);

        $this->erpOrderTransferMock->expects(static::atLeastOnce())
            ->method('getOrderItems')
            ->willReturn($erpOrderItemCollection);

        $this->erpOrderCancellationItemTransferMock->expects(static::atLeastOnce())
            ->method('getSku')
            ->willReturn('sku');

        $this->erpOrderItemTransferMock->expects(static::atLeastOnce())
            ->method('getSku')
            ->willReturn('sku');

        $this->erpOrderCancellationItemTransferMock->expects(static::atLeastOnce())
            ->method('getLineId')
            ->willReturn('100');

        $this->erpOrderItemTransferMock->expects(static::atLeastOnce())
            ->method('getLineId')
            ->willReturn('100');

        $this->erpOrderCancellationItemTransferMock->expects(static::atLeastOnce())
            ->method('setCancellationValue')
            ->with(10)
            ->willReturnSelf();

        $this->erpOrderCancellationItemTransferMock->expects(static::atLeastOnce())
            ->method('setValueBeforeCancellation')
            ->with(20)
            ->willReturnSelf();

        $this->erpOrderCancellationItemTransferMock->expects(static::atLeastOnce())
            ->method('setQuantityBeforeCancellation')
            ->with(2)
            ->willReturnSelf();

        $this->erpOrderCancellationItemTransferMock->expects(static::atLeastOnce())
            ->method('setUnitPrice')
            ->with(10)
            ->willReturnSelf();

        $this->erpOrderCancellationItemTransferMock->expects(static::atLeastOnce())
            ->method('setName')
            ->with('testName')
            ->willReturnSelf();

        $this->erpOrderCancellationItemTransferMock->expects(static::atLeastOnce())
            ->method('setPosition')
            ->with(99)
            ->willReturnSelf();

        $this->erpOrderAmountTransferMock->expects(static::atLeastOnce())
            ->method('getValue')
            ->willReturn(10);

        $this->erpOrderItemTransferMock->expects(static::atLeastOnce())
            ->method('getOrderedQuantity')
            ->willReturn(2);

        $this->erpOrderItemTransferMock->expects(static::atLeastOnce())
            ->method('getUnitPrice')
            ->willReturn($this->erpOrderAmountTransferMock);

        $this->erpOrderItemTransferMock->expects(static::atLeastOnce())
            ->method('getName')
            ->willReturn('testName');

        $this->erpOrderItemTransferMock->expects(static::atLeastOnce())
            ->method('getPosition')
            ->willReturn(99);

        $this->erpOrderCancellationItemTransferMock->expects(static::atLeastOnce())
            ->method('getCancellationQuantity')
            ->willReturn(1);

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('setCancellationItems')
            ->willReturnSelf();

        $this->erpOrderCancellationTransferMock->expects(static::atLeastOnce())
            ->method('setCurrencyIsoCode')
            ->with('EUR')
            ->willReturnSelf();

        $this->erpOrderTransferMock->expects(static::atLeastOnce())
            ->method('getCurrencyIsoCode')
            ->willReturn('EUR');

        $this->plugin->preSave($this->erpOrderCancellationTransferMock);
    }
}
