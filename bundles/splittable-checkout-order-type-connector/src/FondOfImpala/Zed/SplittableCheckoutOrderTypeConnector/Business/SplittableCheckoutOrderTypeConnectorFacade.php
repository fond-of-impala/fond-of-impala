<?php

namespace FondOfImpala\Zed\SplittableCheckoutOrderTypeConnector\Business;

use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestSplittableCheckoutRequestTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfImpala\Zed\SplittableCheckoutOrderTypeConnector\Business\SplittableCheckoutOrderTypeConnectorBusinessFactory getFactory()
 */
class SplittableCheckoutOrderTypeConnectorFacade extends AbstractFacade implements SplittableCheckoutOrderTypeConnectorFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestSplittableCheckoutRequestTransfer $restSplittableCheckoutRequestTransfer
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function expandQuote(
        RestSplittableCheckoutRequestTransfer $restSplittableCheckoutRequestTransfer,
        QuoteTransfer $quoteTransfer
    ): QuoteTransfer {
        return $this->getFactory()->createQuoteExpander()->expand($restSplittableCheckoutRequestTransfer, $quoteTransfer);
    }
}
