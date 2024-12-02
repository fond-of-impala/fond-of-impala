<?php

namespace FondOfImpala\Zed\ErpOrderCancellationMailConnector\Communication\Plugin\ErpOrderCancellation\PostSave;

use FondOfImpala\Zed\ErpOrderCancellationExtension\Dependency\Plugin\ErpOrderCancellationPostSavePluginInterface;
use Generated\Shared\Transfer\ErpOrderCancellationTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\ErpOrderCancellationMailConnector\Business\ErpOrderCancellationMailConnectorFacadeInterface getFacade()
 */
class ErpOrderCancellationNotifyPersistorErpOrderCancellationPostSavePlugin extends AbstractPlugin implements ErpOrderCancellationPostSavePluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationTransfer $erpOrderCancellationTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationTransfer
     */
    public function postSave(ErpOrderCancellationTransfer $erpOrderCancellationTransfer): ErpOrderCancellationTransfer
    {
        return $this->getFacade()->persistNotificationChain($erpOrderCancellationTransfer);
    }
}
