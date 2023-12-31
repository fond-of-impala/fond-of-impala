<?php

declare(strict_types = 1);

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Communication\Plugin\QuoteExtension;

use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\QuoteExtension\Dependency\Plugin\QuoteWritePluginInterface;

/**
 * @method \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\ConditionalAvailabilityCartConnectorFacadeInterface getFacade()
 */
class DeliveryDateCleanerOnEmptyCartQuoteAfterSavePlugin extends AbstractPlugin implements QuoteWritePluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function execute(QuoteTransfer $quoteTransfer): QuoteTransfer
    {
        return $this->getFacade()->cleanDeliveryDateOnEmptyCart($quoteTransfer);
    }
}
