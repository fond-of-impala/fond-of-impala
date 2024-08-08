<?php

namespace FondOfImpala\Zed\SplittableCheckoutOrderTypeConnector\Business;

use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestSplittableCheckoutRequestTransfer;
use Generated\Shared\Transfer\SpySalesOrderEntityTransfer;
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

    /**
     * @param \Generated\Shared\Transfer\RestSplittableCheckoutRequestTransfer $restSplittableCheckoutRequestTransfer
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function expandTypesQuote(
        RestSplittableCheckoutRequestTransfer $restSplittableCheckoutRequestTransfer,
        QuoteTransfer $quoteTransfer
    ): QuoteTransfer {
        return $this->getFactory()->createQuoteExpander()->expandTypes($restSplittableCheckoutRequestTransfer, $quoteTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\SpySalesOrderEntityTransfer $spySalesOrderEntityTransfer
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\SpySalesOrderEntityTransfer
     */
    public function expandSalesOrder(
        SpySalesOrderEntityTransfer $spySalesOrderEntityTransfer,
        QuoteTransfer $quoteTransfer
    ): SpySalesOrderEntityTransfer {
        return $this->getFactory()->createSalesOrderExpander()->expand($spySalesOrderEntityTransfer, $quoteTransfer);
    }
}
