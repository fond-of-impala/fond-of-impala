<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Communication\Plugin\ErpOrderCancellation\PreSave;

use FondOfImpala\Zed\ErpOrderCancellationExtension\Dependency\Plugin\ErpOrderCancellationPreSavePluginInterface;
use Generated\Shared\Transfer\ErpOrderCancellationTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\ErpOrderCancellationRestApi\Communication\ErpOrderCancellationRestApiCommunicationFactory getFactory()
 */
class CancellationCalculationsErpOrderCancellationPreSavePlugin extends AbstractPlugin implements ErpOrderCancellationPreSavePluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationTransfer $erpOrderCancellationTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationTransfer
     */
    public function preSave(ErpOrderCancellationTransfer $erpOrderCancellationTransfer): ErpOrderCancellationTransfer
    {
        $erpOrderReference = $erpOrderCancellationTransfer->getErpOrderReference();
        $erpOrder = null;

        if ($erpOrderReference !== null) {
            $erpOrder = $this->getFactory()->getErpOrderFacade()->findErpOrderByReference($erpOrderReference);
        }

        if ($erpOrder === null) {
            return $erpOrderCancellationTransfer;
        }

        foreach ($erpOrderCancellationTransfer->getCancellationItems() as $cancellationItem) {
            foreach ($erpOrder->getOrderItems() as $item) {
                if ($cancellationItem->getSku() === $item->getSku() && $cancellationItem->getLineId() === $item->getLineId()) {
                    $cancellationItem
                        ->setCancellationValue($item->getAmount()->getValue() / $item->getOrderedQuantity() * $cancellationItem->getCancellationQuantity())
                        ->setValueBeforeCancellation($item->getAmount()->getValue())
                        ->setQuantityBeforeCancellation($item->getOrderedQuantity());
                }
            }
        }

        return $erpOrderCancellationTransfer
            ->setCurrencyIsoCode($erpOrder->getCurrencyIsoCode());
    }
}
