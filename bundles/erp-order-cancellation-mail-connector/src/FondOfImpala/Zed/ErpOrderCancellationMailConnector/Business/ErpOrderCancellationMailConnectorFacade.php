<?php

namespace FondOfImpala\Zed\ErpOrderCancellationMailConnector\Business;

use Generated\Shared\Transfer\ErpOrderCancellationMailConfigResponseTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationMailConfigTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfImpala\Zed\ErpOrderCancellationMailConnector\Business\ErpOrderCancellationMailConnectorBusinessFactory getFactory()
 */
class ErpOrderCancellationMailConnectorFacade extends AbstractFacade implements ErpOrderCancellationMailConnectorFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationMailConfigTransfer $erpOrderCancellationMailConfigTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationMailConfigResponseTransfer
     */
    public function handleMails(ErpOrderCancellationMailConfigTransfer $erpOrderCancellationMailConfigTransfer): ErpOrderCancellationMailConfigResponseTransfer
    {
        return $this->getFactory()->createMailHandler()->sendMail($erpOrderCancellationMailConfigTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationTransfer $erpOrderCancellationTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationTransfer
     */
    public function persistNotificationChain(ErpOrderCancellationTransfer $erpOrderCancellationTransfer): ErpOrderCancellationTransfer
    {
        return $this->getFactory()->createNotificationChainHandler()->handleNotificationChain($erpOrderCancellationTransfer);
    }
}
