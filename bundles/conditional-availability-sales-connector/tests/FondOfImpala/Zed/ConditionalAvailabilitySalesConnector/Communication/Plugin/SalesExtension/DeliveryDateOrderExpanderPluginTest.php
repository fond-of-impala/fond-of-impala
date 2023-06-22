<?php

namespace FondOfImpala\Zed\ConditionalAvailabilitySalesConnector\Communication\Plugin\SalesExtension;

use ArrayObject;
use Codeception\Test\Unit;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\OrderTransfer;

class DeliveryDateOrderExpanderPluginTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\OrderTransfer
     */
    protected $orderTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ItemTransfer
     */
    protected $itemTransferMock;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilitySalesConnector\Communication\Plugin\SalesExtension\DeliveryDateOrderExpanderPlugin
     */
    protected $deliveryDateOrderExpanderPlugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->orderTransferMock = $this->getMockBuilder(OrderTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->itemTransferMock = $this->getMockBuilder(ItemTransfer::class)
                ->disableOriginalConstructor()
                ->getMock();

        $this->deliveryDateOrderExpanderPlugin = new DeliveryDateOrderExpanderPlugin();
    }

    /**
     * @return void
     */
    public function testHydrate(): void
    {
        $deliveryDate = 'earliest';
        $concreteDeliveryDate = '2020-07-14';

        $this->orderTransferMock->expects($this->atLeastOnce())
            ->method('getItems')
            ->willReturn(new ArrayObject([$this->itemTransferMock]));

        $this->itemTransferMock->expects($this->atLeastOnce())
            ->method('getDeliveryDate')
            ->willReturn($deliveryDate);

        $this->orderTransferMock->expects($this->atLeastOnce())
            ->method('setDeliveryDate')
            ->with($deliveryDate)
            ->willReturn($this->orderTransferMock);

        $this->itemTransferMock->expects($this->atLeastOnce())
            ->method('getConcreteDeliveryDate')
            ->willReturn($concreteDeliveryDate);

        $this->orderTransferMock->expects($this->atLeastOnce())
            ->method('setConcreteDeliveryDate')
            ->with($concreteDeliveryDate)
            ->willReturn($this->orderTransferMock);

        $orderTransfer = $this->deliveryDateOrderExpanderPlugin->hydrate($this->orderTransferMock);

        $this->assertEquals($orderTransfer, $this->orderTransferMock);
    }

    /**
     * @return void
     */
    public function testHydrateWithoutItems(): void
    {
        $this->orderTransferMock->expects($this->atLeastOnce())
            ->method('getItems')
            ->willReturn(new ArrayObject());

        $this->orderTransferMock->expects($this->never())
            ->method('setDeliveryDate');

        $this->orderTransferMock->expects($this->never())
            ->method('setConcreteDeliveryDate');

        $orderTransfer = $this->deliveryDateOrderExpanderPlugin->hydrate($this->orderTransferMock);

        $this->assertEquals($orderTransfer, $this->orderTransferMock);
    }
}
