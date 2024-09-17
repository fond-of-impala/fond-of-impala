<?php

namespace FondOfImpala\Zed\ErpOrderCancellation\Communication\Plugin\PreSave;

use FondOfImpala\Zed\ErpOrderCancellationExtension\Dependency\Plugin\ErpOrderCancellationPreSavePluginInterface;
use Generated\Shared\Transfer\ErpOrderCancellationTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\ErpOrderCancellation\Business\ErpOrderCancellationFacadeInterface getFacade()
 * @method \FondOfImpala\Zed\ErpOrderCancellation\ErpOrderCancellationConfig getConfig()
 */
class GenerateCancellationReferenceErpOrderCancellationPreSavePlugin extends AbstractPlugin implements ErpOrderCancellationPreSavePluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationTransfer $erpOrderCancellationTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationTransfer
     */
    public function preSave(ErpOrderCancellationTransfer $erpOrderCancellationTransfer): ErpOrderCancellationTransfer
    {
        $reference = $erpOrderCancellationTransfer->getErpOrderReference();

        if ($reference === null) {
            return $erpOrderCancellationTransfer;
        }

        return $erpOrderCancellationTransfer->setCancellationNumber(str_replace($this->getConfig()->getPrefixToReplace(), $this->getConfig()->getPrefix(), $reference));
    }
}
