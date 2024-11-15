<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Communication\Plugin\ErpOrderCancellation\PreSave;

use ArrayObject;
use Exception;
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
     * @throws \Exception
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationTransfer
     */
    public function preSave(ErpOrderCancellationTransfer $erpOrderCancellationTransfer): ErpOrderCancellationTransfer
    {
        if (count($erpOrderCancellationTransfer->getCancellationItems()) === 0) {
            return $erpOrderCancellationTransfer;
        }

        $erpOrderCancellationTransfer->requireErpOrderReference();
        $erpOrder = $this->getFactory()->getErpOrderFacade()->findErpOrderByReference($erpOrderCancellationTransfer->getErpOrderReference());

        if ($erpOrder === null) {
            throw new Exception(sprintf('ErpOrder not found for reference "%s"', $erpOrderCancellationTransfer->getErpOrderReference()));
        }

        $items = new ArrayObject();
        foreach ($erpOrderCancellationTransfer->getCancellationItems() as $cancellationItem) {
            foreach ($erpOrder->getOrderItems() as $item) {
                if ($cancellationItem->getSku() === $item->getSku() && $cancellationItem->getLineId() === $item->getLineId()) {
                    $cancellationItem
                        ->setCancellationValue($item->getAmount()->getValue() / $item->getOrderedQuantity() * $cancellationItem->getCancellationQuantity())
                        ->setValueBeforeCancellation($item->getAmount()->getValue())
                        ->setQuantityBeforeCancellation($item->getOrderedQuantity())
                        ->setUnitPrice($item->getUnitPrice()->getValue())
                        ->setName($item->getName())
                        ->setPosition($item->getPosition());
                    $items->append($cancellationItem);
                }
            }
        }

        return $erpOrderCancellationTransfer
            ->setCancellationItems($items)
            ->setCurrencyIsoCode($erpOrder->getCurrencyIsoCode());
    }
}
