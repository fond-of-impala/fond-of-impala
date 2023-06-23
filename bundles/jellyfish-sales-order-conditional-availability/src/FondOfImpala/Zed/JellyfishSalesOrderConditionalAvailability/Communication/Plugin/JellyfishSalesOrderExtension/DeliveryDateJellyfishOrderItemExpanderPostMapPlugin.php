<?php

namespace FondOfImpala\Zed\JellyfishSalesOrderConditionalAvailability\Communication\Plugin\JellyfishSalesOrderExtension;

use FondOfOryx\Zed\JellyfishSalesOrderExtension\Dependency\Plugin\JellyfishOrderItemExpanderPostMapPluginInterface;
use Generated\Shared\Transfer\JellyfishOrderItemTransfer;
use Orm\Zed\Sales\Persistence\SpySalesOrderItem;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

class DeliveryDateJellyfishOrderItemExpanderPostMapPlugin extends AbstractPlugin implements JellyfishOrderItemExpanderPostMapPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\JellyfishOrderItemTransfer $jellyfishOrderItemTransfer
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem $salesOrderItem
     *
     * @return \Generated\Shared\Transfer\JellyfishOrderItemTransfer
     */
    public function expand(
        JellyfishOrderItemTransfer $jellyfishOrderItemTransfer,
        SpySalesOrderItem $salesOrderItem
    ): JellyfishOrderItemTransfer {
        $deliveryDate = $salesOrderItem->getConcreteDeliveryDate();

        $jellyfishOrderItemTransfer->setDeliveryDate($deliveryDate);

        return $jellyfishOrderItemTransfer;
    }
}
