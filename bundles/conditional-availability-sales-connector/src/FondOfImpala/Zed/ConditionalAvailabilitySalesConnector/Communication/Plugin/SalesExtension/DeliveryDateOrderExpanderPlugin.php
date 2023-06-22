<?php

namespace FondOfImpala\Zed\ConditionalAvailabilitySalesConnector\Communication\Plugin\SalesExtension;

use Generated\Shared\Transfer\OrderTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\SalesExtension\Dependency\Plugin\OrderExpanderPluginInterface;

class DeliveryDateOrderExpanderPlugin extends AbstractPlugin implements OrderExpanderPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return \Generated\Shared\Transfer\OrderTransfer
     */
    public function hydrate(OrderTransfer $orderTransfer): OrderTransfer
    {
        $itemTransfers = $orderTransfer->getItems();

        if ($itemTransfers->count() === 0) {
            return $orderTransfer;
        }

        $itemTransfer = $itemTransfers->offsetGet(0);

        return $orderTransfer->setDeliveryDate($itemTransfer->getDeliveryDate())
            ->setConcreteDeliveryDate($itemTransfer->getConcreteDeliveryDate());
    }
}
