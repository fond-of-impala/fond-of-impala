<?php

namespace FondOfImpala\Zed\ErpOrderCancellationMailConnector\Business\Model\Mail;

use Generated\Shared\Transfer\ErpOrderCancellationMailConfigResponseTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationMailConfigTransfer;

interface MailHandlerInterface
{
    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationMailConfigTransfer $erpOrderCancellationMailConfigTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationMailConfigResponseTransfer
     */
    public function sendMail(ErpOrderCancellationMailConfigTransfer $erpOrderCancellationMailConfigTransfer): ErpOrderCancellationMailConfigResponseTransfer;
}
