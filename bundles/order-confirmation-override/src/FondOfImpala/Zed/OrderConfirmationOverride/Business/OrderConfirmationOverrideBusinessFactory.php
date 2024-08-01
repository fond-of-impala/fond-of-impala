<?php

namespace FondOfImpala\Zed\OrderConfirmationOverride\Business;

use FondOfImpala\Zed\OrderConfirmationOverride\Business\Expander\ExpanderInterface;
use FondOfImpala\Zed\OrderConfirmationOverride\Business\Expander\MailExpander;
use FondOfImpala\Zed\OrderConfirmationOverride\Business\Expander\MailExpanderInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfImpala\Zed\OrderConfirmationOverride\Persistence\OrderConfirmationOverrideRepositoryInterface getRepository()
 */
class OrderConfirmationOverrideBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfImpala\Zed\OrderConfirmationOverride\Business\Expander\MailExpanderInterface
     */
    public function createMailExpander(): MailExpanderInterface
    {
        return new MailExpander(
            $this->getRepository()
        );
    }
}
