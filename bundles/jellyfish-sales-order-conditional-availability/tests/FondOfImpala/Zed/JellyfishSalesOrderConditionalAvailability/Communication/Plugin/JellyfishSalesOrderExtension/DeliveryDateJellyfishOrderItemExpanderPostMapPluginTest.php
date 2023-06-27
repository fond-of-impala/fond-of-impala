<?php

namespace FondOfImpala\Zed\JellyfishSalesOrderConditionalAvailability\Communication\Plugin\JellyfishSalesOrderExtension;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\JellyfishOrderItemTransfer;
use Orm\Zed\Sales\Persistence\SpySalesOrderItem;
use PHPUnit\Framework\MockObject\MockObject;

class DeliveryDateJellyfishOrderItemExpanderPostMapPluginTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\JellyfishOrderItemTransfer
     */
    protected MockObject|JellyfishOrderItemTransfer $jellyfishOrderItemTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Orm\Zed\Sales\Persistence\SpySalesOrderItem
     */
    protected MockObject|SpySalesOrderItem $spySalesOrderItemMock;

    /**
     * @var \FondOfImpala\Zed\JellyfishSalesOrderConditionalAvailability\Communication\Plugin\JellyfishSalesOrderExtension\DeliveryDateJellyfishOrderItemExpanderPostMapPlugin
     */
    protected DeliveryDateJellyfishOrderItemExpanderPostMapPlugin $plugin;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->jellyfishOrderItemTransferMock = $this->getMockBuilder(JellyfishOrderItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->spySalesOrderItemMock = $this->getMockBuilder(SpySalesOrderItem::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new DeliveryDateJellyfishOrderItemExpanderPostMapPlugin();
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $concreteDeliveryDate = '2022-01-02';

        $this->spySalesOrderItemMock->expects(static::atLeastOnce())
            ->method('getConcreteDeliveryDate')
            ->willReturn($concreteDeliveryDate);

        $this->jellyfishOrderItemTransferMock->expects(static::atLeastOnce())
            ->method('setDeliveryDate')
            ->with($concreteDeliveryDate)
            ->willReturn($this->jellyfishOrderItemTransferMock);

        static::assertEquals(
            $this->jellyfishOrderItemTransferMock,
            $this->plugin->expand(
                $this->jellyfishOrderItemTransferMock,
                $this->spySalesOrderItemMock,
            ),
        );
    }
}
