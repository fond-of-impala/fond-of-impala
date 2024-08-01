<?php

namespace FondOfImpala\Zed\OrderConfirmationOverride\Business;

use Generated\Shared\Transfer\MailTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfImpala\Zed\OrderConfirmationOverride\Business\OrderConfirmationOverrideBusinessFactory getFactory()
 */
class OrderConfirmationOverrideFacade extends AbstractFacade implements OrderConfirmationOverrideFacadeInterface
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
