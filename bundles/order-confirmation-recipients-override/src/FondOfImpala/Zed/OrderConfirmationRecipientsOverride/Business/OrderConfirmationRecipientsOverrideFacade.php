<?php

namespace FondOfImpala\Zed\OrderConfirmationRecipientsOverride\Business;

use Generated\Shared\Transfer\MailTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfImpala\Zed\OrderConfirmationRecipientsOverride\Business\OrderConfirmationRecipientsOverrideBusinessFactory getFactory()
 */
class OrderConfirmationRecipientsOverrideFacade extends AbstractFacade implements OrderConfirmationRecipientsOverrideFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\MailTransfer $mailTransfer
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return \Generated\Shared\Transfer\MailTransfer
     */
    public function expandOrderMailTransfer(MailTransfer $mailTransfer, OrderTransfer $orderTransfer): MailTransfer
    {
        return $this->getFactory()->createMailExpander()->expand($mailTransfer, $orderTransfer);
    }
}
