<?php

namespace FondOfImpala\Zed\OrderConfirmationRecipientsOverride\Business\Expander;

use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestSplittableCheckoutRequestTransfer;

class QuoteExpander implements QuoteExpanderInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestSplittableCheckoutRequestTransfer $restSplittableCheckoutRequestTransfer
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function expand(
        RestSplittableCheckoutRequestTransfer $restSplittableCheckoutRequestTransfer,
        QuoteTransfer $quoteTransfer
    ): QuoteTransfer {
        $preventOrderMail = $restSplittableCheckoutRequestTransfer->getPreventCustomerOrderConfirmationMail();

        if ($preventOrderMail === null || is_bool($preventOrderMail) === false) {
            return $quoteTransfer;
        }

        return $quoteTransfer->setPreventCustomerOrderConfirmationMail($preventOrderMail);
    }
}
