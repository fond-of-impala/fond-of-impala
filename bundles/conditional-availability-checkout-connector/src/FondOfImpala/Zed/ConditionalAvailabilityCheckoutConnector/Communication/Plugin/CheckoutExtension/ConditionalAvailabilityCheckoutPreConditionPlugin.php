<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Communication\Plugin\CheckoutExtension;

use Generated\Shared\Transfer\CheckoutResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Zed\CheckoutExtension\Dependency\Plugin\CheckoutPreConditionPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Business\ConditionalAvailabilityCheckoutConnectorFacadeInterface getFacade()
 */
class ConditionalAvailabilityCheckoutPreConditionPlugin extends AbstractPlugin implements CheckoutPreConditionPluginInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\CheckoutResponseTransfer $checkoutResponseTransfer
     *
     * @return bool
     */
    public function checkCondition(
        QuoteTransfer $quoteTransfer,
        CheckoutResponseTransfer $checkoutResponseTransfer
    ): bool {
        return $this->getFacade()->checkAvailabilities($quoteTransfer, $checkoutResponseTransfer);
    }
}
