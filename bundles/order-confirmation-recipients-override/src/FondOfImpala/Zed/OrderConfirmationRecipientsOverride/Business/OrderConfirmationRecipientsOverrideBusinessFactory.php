<?php

namespace FondOfImpala\Zed\OrderConfirmationRecipientsOverride\Business;

use FondOfImpala\Zed\OrderConfirmationRecipientsOverride\Business\Expander\MailExpander;
use FondOfImpala\Zed\OrderConfirmationRecipientsOverride\Business\Expander\MailExpanderInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfImpala\Zed\OrderConfirmationRecipientsOverride\Persistence\OrderConfirmationRecipientsOverrideRepositoryInterface getRepository()
 */
class OrderConfirmationRecipientsOverrideBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfImpala\Zed\OrderConfirmationRecipientsOverride\Business\Expander\MailExpanderInterface
     */
    public function createMailExpander(): MailExpanderInterface
    {
        return new MailExpander(
            $this->getRepository(),
        );
    }
}
