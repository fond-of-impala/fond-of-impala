<?php

namespace FondOfImpala\Zed\OrderConfirmationRecipientsOverride\Communication\Plugin\SplittableCheckoutRestApiExtension;

use FondOfOryx\Zed\SplittableCheckoutRestApiExtension\Dependency\Plugin\QuoteExpanderPluginInterface;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestSplittableCheckoutRequestTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\OrderConfirmationRecipientsOverride\Business\OrderConfirmationRecipientsOverrideFacadeInterface getFacade()
 */
class OrderPreventCustomerEmailQuoteExpanderPlugin extends AbstractPlugin implements QuoteExpanderPluginInterface
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
        return $this->getFacade()->expandQuote($restSplittableCheckoutRequestTransfer, $quoteTransfer);
    }
}
