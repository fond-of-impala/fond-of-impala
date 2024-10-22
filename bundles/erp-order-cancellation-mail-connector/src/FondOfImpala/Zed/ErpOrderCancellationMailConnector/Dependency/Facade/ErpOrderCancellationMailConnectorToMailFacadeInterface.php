<?php

namespace FondOfImpala\Zed\ErpOrderCancellationMailConnector\Dependency\Facade;

use Generated\Shared\Transfer\MailTransfer;

interface ErpOrderCancellationMailConnectorToMailFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\MailTransfer $mailTransfer
     *
     * @return void
     */
    public function handleMail(MailTransfer $mailTransfer): void;
}
