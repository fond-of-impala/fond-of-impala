<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Communication\Plugin\CartExtension;

use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Zed\CartExtension\Dependency\Plugin\PostReloadItemsPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\ConditionalAvailabilityCartConnectorFacadeInterface getFacade()
 */
class ConditionalAvailabilityCartConnectorPostReloadItemsPlugin extends AbstractPlugin implements PostReloadItemsPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function postReloadItems(QuoteTransfer $quoteTransfer): QuoteTransfer
    {
        return $this->getFacade()->expandQuote($quoteTransfer);
    }
}
