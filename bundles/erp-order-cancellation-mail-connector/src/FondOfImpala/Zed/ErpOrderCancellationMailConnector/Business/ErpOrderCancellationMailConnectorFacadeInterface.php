<?php

namespace FondOfImpala\Zed\ErpOrderCancellationMailConnector\Business;

use Generated\Shared\Transfer\ErpOrderCancellationMailConfigResponseTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationMailConfigTransfer;

interface ErpOrderCancellationMailConnectorFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationMailConfigTransfer $erpOrderCancellationMailConfigTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationMailConfigResponseTransfer
     */
    public function handleMails(ErpOrderCancellationMailConfigTransfer $erpOrderCancellationMailConfigTransfer): ErpOrderCancellationMailConfigResponseTransfer;
}
