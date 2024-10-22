<?php

namespace FondOfImpala\Zed\ErpOrderCancellationMailConnector\Business;

use Generated\Shared\Transfer\ErpOrderCancellationMailConfigResponseTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationMailConfigTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfImpala\Zed\ErpOrderCancellationMailConnector\Business\ErpOrderCancellationMailConnectorBusinessFactory getFactory()
 */
class ErpOrderCancellationMailConnectorFacade extends AbstractFacade implements ErpOrderCancellationMailConnectorFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationMailConfigTransfer $erpOrderCancellationMailConfigTransfer
     * @return \Generated\Shared\Transfer\ErpOrderCancellationMailConfigResponseTransfer
     */
    public function handleMails(ErpOrderCancellationMailConfigTransfer $erpOrderCancellationMailConfigTransfer): ErpOrderCancellationMailConfigResponseTransfer
    {
        return $this->getFactory()->createMailHandler()->sendMail($erpOrderCancellationMailConfigTransfer);
    }
}
