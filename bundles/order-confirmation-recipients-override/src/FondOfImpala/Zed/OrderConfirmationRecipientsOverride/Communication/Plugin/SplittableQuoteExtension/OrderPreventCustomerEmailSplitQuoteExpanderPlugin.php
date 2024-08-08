<?php

namespace FondOfImpala\Zed\OrderConfirmationRecipientsOverride\Communication\Plugin\SplittableQuoteExtension;

use FondOfOryx\Zed\SplittableQuoteExtension\Dependency\Plugin\SplittedQuoteExpanderPluginInterface;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

class OrderPreventCustomerEmailSplitQuoteExpanderPlugin extends AbstractPlugin implements SplittedQuoteExpanderPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $splitQuoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function expand(QuoteTransfer $splitQuoteTransfer): QuoteTransfer
    {
        $splitKey = $splitQuoteTransfer->getSplitKey();
        $preventCustomerMails = $splitQuoteTransfer->getPreventCustomerOrderConfirmationMails();

        if (count($preventCustomerMails) === 0) {
            return $splitQuoteTransfer;
        }

        $preventCustomerMail = !isset($preventCustomerMails[$splitKey]) ? null : $preventCustomerMails[$splitKey];

        return $splitQuoteTransfer->setPreventCustomerOrderConfirmationMail($preventCustomerMail);
    }
}
