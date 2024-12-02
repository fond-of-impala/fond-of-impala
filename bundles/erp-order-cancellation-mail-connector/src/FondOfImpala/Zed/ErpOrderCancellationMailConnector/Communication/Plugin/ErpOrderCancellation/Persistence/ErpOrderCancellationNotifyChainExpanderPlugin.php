<?php

namespace FondOfImpala\Zed\ErpOrderCancellationMailConnector\Communication\Plugin\ErpOrderCancellation\Persistence;

use FondOfImpala\Zed\ErpOrderCancellationExtension\Dependency\Plugin\Persistence\ErpOrderCancellationTransferExpanderPluginInterface;
use Generated\Shared\Transfer\ErpOrderCancellationNotifyTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationTransfer;
use Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellation;

/**
 * @method \FondOfImpala\Zed\ErpOrderCancellationMailConnector\Persistence\ErpOrderCancellationMailConnectorPersistenceFactory getFactory()
 */
class ErpOrderCancellationNotifyChainExpanderPlugin implements ErpOrderCancellationTransferExpanderPluginInterface
{
    /**
     * @param \Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellation $erpOrderCancellation
     * @param \Generated\Shared\Transfer\ErpOrderCancellationTransfer $erpOrderCancellationTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationTransfer
     */
    public function expand(
        FoiErpOrderCancellation $erpOrderCancellation,
        ErpOrderCancellationTransfer $erpOrderCancellationTransfer
    ): ErpOrderCancellationTransfer {
        $notificationChain = $erpOrderCancellation->getFoiErpOrderCancellationNotifiesJoinSpyCustomer();

        foreach ($notificationChain->getData() as $notification) {
            $spyCustomer = $notification->getSpyCustomer();
            $notifyTransfer = (new ErpOrderCancellationNotifyTransfer())->fromArray($spyCustomer->toArray(), true)
                ->setFkErpOrderCancellation($erpOrderCancellation->getIdErpOrderCancellation())
                ->setFkCustomer($spyCustomer->getIdCustomer());
            $erpOrderCancellationTransfer->addNotify($notifyTransfer);
        }

        return $erpOrderCancellationTransfer;
    }
}
