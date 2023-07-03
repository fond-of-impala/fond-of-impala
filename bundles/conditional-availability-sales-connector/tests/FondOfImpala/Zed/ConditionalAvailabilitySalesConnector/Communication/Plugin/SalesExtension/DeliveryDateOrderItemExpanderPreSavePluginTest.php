<?php

namespace FondOfImpala\Zed\ConditionalAvailabilitySalesConnector\Communication\Plugin\SalesExtension;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SpySalesOrderItemEntityTransfer;
use PHPUnit\Framework\MockObject\MockObject;

class DeliveryDateOrderItemExpanderPreSavePluginTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\QuoteTransfer
     */
    protected MockObject|QuoteTransfer $quoteTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ItemTransfer
     */
    protected MockObject|ItemTransfer $itemTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\SpySalesOrderItemEntityTransfer
     */
    protected MockObject|SpySalesOrderItemEntityTransfer $spySalesOrderItemEntityTransferMock;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilitySalesConnector\Communication\Plugin\SalesExtension\DeliveryDateOrderItemExpanderPreSavePlugin
     */
    protected DeliveryDateOrderItemExpanderPreSavePlugin $plugin;

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

        $this->spySalesOrderItemEntityTransferMock = $this->getMockBuilder(SpySalesOrderItemEntityTransfer::class)
            ->disableOriginalConstructor()
            ->setMethods(['setDeliveryDate', 'setConcreteDeliveryDate'])
            ->getMock();

        $this->plugin = new DeliveryDateOrderItemExpanderPreSavePlugin();
    }

    /**
     * @return void
     */
    public function testExpandOrderItem(): void
    {
        $deliveryDate = 'earliest';
        $concreteDeliveryDate = '2020-07-14';

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getDeliveryDate')
            ->willReturn($deliveryDate);

        $this->spySalesOrderItemEntityTransferMock->expects(static::atLeastOnce())
            ->method('setDeliveryDate')
            ->with($deliveryDate)
            ->willReturn($this->spySalesOrderItemEntityTransferMock);

        $this->itemTransferMock->expects(static::atLeastOnce())
            ->method('getConcreteDeliveryDate')
            ->willReturn($concreteDeliveryDate);

        $this->spySalesOrderItemEntityTransferMock->expects(static::atLeastOnce())
            ->method('setConcreteDeliveryDate')
            ->with($concreteDeliveryDate)
            ->willReturn($this->spySalesOrderItemEntityTransferMock);

        $spySalesOrderItemEntityTransfer = $this->plugin->expandOrderItem(
            $this->quoteTransferMock,
            $this->itemTransferMock,
            $this->spySalesOrderItemEntityTransferMock,
        );

        static::assertEquals($this->spySalesOrderItemEntityTransferMock, $spySalesOrderItemEntityTransfer);
    }
}
