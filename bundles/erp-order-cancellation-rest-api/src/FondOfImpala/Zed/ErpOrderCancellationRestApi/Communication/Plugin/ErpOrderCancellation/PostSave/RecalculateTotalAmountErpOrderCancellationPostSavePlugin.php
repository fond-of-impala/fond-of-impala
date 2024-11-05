<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Communication\Plugin\ErpOrderCancellation\PostSave;


use FondOfImpala\Zed\ErpOrderCancellationExtension\Dependency\Plugin\ErpOrderCancellationPostSavePluginInterface;
use Generated\Shared\Transfer\ErpOrderCancellationTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\ErpOrderCancellationRestApiFacadeInterface getFacade()
 */
class RecalculateTotalAmountErpOrderCancellationPostSavePlugin extends AbstractPlugin implements ErpOrderCancellationPostSavePluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationTransfer $erpOrderCancellationTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationTransfer
     */
    public function postSave(ErpOrderCancellationTransfer $erpOrderCancellationTransfer): ErpOrderCancellationTransfer
    {
        $amount = 0;

        foreach ($erpOrderCancellationTransfer->getCancellationItems() as $cancellationItem) {
            $amount += $cancellationItem->getCancellationValue();
        }

        $erpOrderCancellationTransfer->setAmount($amount);
        return $this->getFacade()->updateErpOrderCancellationAmount($erpOrderCancellationTransfer);
    }
}
