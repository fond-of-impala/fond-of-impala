<?php

namespace FondOfImpala\Zed\ConditionalAvailabilitySalesConnector\Communication\Plugin\SalesExtension;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

class DeliveryDateOrderItemExpanderPreSavePluginTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\QuoteTransfer
     */
    protected $quoteTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ItemTransfer
     */
    protected $itemTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\SpySalesOrderItemEntityTransfer
     */
    protected $spySalesOrderItemEntityTransferMock;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilitySalesConnector\Communication\Plugin\SalesExtension\DeliveryDateOrderItemExpanderPreSavePlugin
     */
    protected $deliveryDateOrderItemExpanderPreSavePlugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->itemTransferMock = $this->getMockBuilder(ItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->spySalesOrderItemEntityTransferMock = $this->getMockBuilder('\Generated\Shared\Transfer\SpySalesOrderItemEntityTransfer')
            ->disableOriginalConstructor()
            ->setMethods(['setDeliveryDate', 'setConcreteDeliveryDate'])
            ->getMock();

        $this->deliveryDateOrderItemExpanderPreSavePlugin = new DeliveryDateOrderItemExpanderPreSavePlugin();
    }

    /**
     * @return void
     */
    public function testExpandOrderItem(): void
    {
        $deliveryDate = 'earliest';
        $concreteDeliveryDate = '2020-07-14';

        $this->itemTransferMock->expects($this->atLeastOnce())
            ->method('getDeliveryDate')
            ->willReturn($deliveryDate);

        $this->spySalesOrderItemEntityTransferMock->expects($this->atLeastOnce())
            ->method('setDeliveryDate')
            ->with($deliveryDate)
            ->willReturn($this->spySalesOrderItemEntityTransferMock);

        $this->itemTransferMock->expects($this->atLeastOnce())
            ->method('getConcreteDeliveryDate')
            ->willReturn($concreteDeliveryDate);

        $this->spySalesOrderItemEntityTransferMock->expects($this->atLeastOnce())
            ->method('setConcreteDeliveryDate')
            ->with($concreteDeliveryDate)
            ->willReturn($this->spySalesOrderItemEntityTransferMock);

        $spySalesOrderItemEntityTransfer = $this->deliveryDateOrderItemExpanderPreSavePlugin->expandOrderItem(
            $this->quoteTransferMock,
            $this->itemTransferMock,
            $this->spySalesOrderItemEntityTransferMock,
        );

        $this->assertEquals($this->spySalesOrderItemEntityTransferMock, $spySalesOrderItemEntityTransfer);
    }
}
