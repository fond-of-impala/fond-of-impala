<?php

namespace FondOfImpala\Zed\ErpOrderCancellationMailConnector\Communication\Plugin\ErpOrderCancellation;

use FondOfImpala\Zed\ErpOrderCancellationExtension\Dependency\Plugin\ErpOrderCancellationPostTransactionPluginInterface;
use FondOfImpala\Zed\ErpOrderCancellationMailConnector\Communication\Plugin\Mail\NotifyApprovedErpOrderCancellationMailTypePlugin;
use Generated\Shared\Transfer\ErpOrderCancellationMailConfigTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationResponseTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\ErpOrderCancellationMailConnector\Business\ErpOrderCancellationMailConnectorFacadeInterface getFacade()
 * @method \FondOfImpala\Zed\ErpOrderCancellationMailConnector\ErpOrderCancellationMailConnectorConfig getConfig()
 * @method \FondOfImpala\Zed\ErpOrderCancellationMailConnector\Persistence\ErpOrderCancellationMailConnectorRepositoryInterface getRepository()
 */
class NotifyApprovedErpOrderCancellationPostTransactionPlugin extends AbstractPlugin implements ErpOrderCancellationPostTransactionPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationResponseTransfer $erpOrderCancellationResponseTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationResponseTransfer
     */
    public function postTransaction(ErpOrderCancellationResponseTransfer $erpOrderCancellationResponseTransfer): ErpOrderCancellationResponseTransfer
    {
        $erpOrderCancellationTransfer = $erpOrderCancellationResponseTransfer->getErpOrderCancellation();

        if (
            $erpOrderCancellationTransfer === null
            || !$erpOrderCancellationResponseTransfer->getIsSuccessful()
            || $erpOrderCancellationTransfer->getState() !== 'approved'
        ) {
            return $erpOrderCancellationResponseTransfer;
        }

        $mailConfig = (new ErpOrderCancellationMailConfigTransfer())
            ->setType(NotifyApprovedErpOrderCancellationMailTypePlugin::MAIL_TYPE)
            ->setRoleNames($this->getConfig()->getRolesToNotify())
            ->setCancellation($erpOrderCancellationTransfer);
        $response = $this->getFacade()->handleMails($mailConfig);

        return $erpOrderCancellationResponseTransfer;
    }
}
