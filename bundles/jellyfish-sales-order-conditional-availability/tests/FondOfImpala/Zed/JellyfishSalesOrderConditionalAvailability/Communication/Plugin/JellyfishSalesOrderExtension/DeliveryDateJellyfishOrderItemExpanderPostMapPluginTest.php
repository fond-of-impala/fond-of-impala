<?php

namespace FondOfImpala\Zed\JellyfishSalesOrderConditionalAvailability\Communication\Plugin\JellyfishSalesOrderExtension;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\JellyfishOrderItemTransfer;
use Orm\Zed\Sales\Persistence\SpySalesOrderItem;

class DeliveryDateJellyfishOrderItemExpanderPostMapPluginTest extends Unit
{
    /**
     * @var \Generated\Shared\Transfer\JellyfishOrderItemTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $jellyfishOrderItemTransferMock;

    /**
     * @var \Orm\Zed\Sales\Persistence\SpySalesOrderItem|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $spySalesOrderItemMock;

    /**
     * @var \FondOfImpala\Zed\JellyfishSalesOrderConditionalAvailability\Communication\Plugin\JellyfishSalesOrderExtension\DeliveryDateJellyfishOrderItemExpanderPostMapPlugin
     */
    protected $plugin;

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
