<?php

namespace FondOfImpala\Zed\ErpOrderCancellation\Communication\Plugin\PostSave;

use FondOfImpala\Zed\ErpOrderCancellationExtension\Dependency\Plugin\ErpOrderCancellationPostSavePluginInterface;
use Generated\Shared\Transfer\ErpOrderCancellationTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\ErpOrderCancellation\Business\ErpOrderCancellationFacadeInterface getFacade()
 */
class ErpOrderCancellationItemPersistorErpOrderCancellationPostSavePlugin extends AbstractPlugin implements ErpOrderCancellationPostSavePluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationTransfer $erpOrderCancellationTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationTransfer
     */
    public function postSave(ErpOrderCancellationTransfer $erpOrderCancellationTransfer): ErpOrderCancellationTransfer
    {
        return $this->getFacade()->persistErpOrderCancellationItem($erpOrderCancellationTransfer);
    }
}
