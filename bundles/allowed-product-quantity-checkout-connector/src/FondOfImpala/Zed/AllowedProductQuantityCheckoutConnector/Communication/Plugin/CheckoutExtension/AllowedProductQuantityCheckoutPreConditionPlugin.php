<?php

namespace FondOfImpala\Zed\AllowedProductQuantityCheckoutConnector\Communication\Plugin\CheckoutExtension;

use Generated\Shared\Transfer\CheckoutResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Zed\CheckoutExtension\Dependency\Plugin\CheckoutPreConditionPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\AllowedProductQuantityCheckoutConnector\AllowedProductQuantityCheckoutConnectorConfig getConfig()
 * @method \FondOfImpala\Zed\AllowedProductQuantityCheckoutConnector\Business\AllowedProductQuantityCheckoutConnectorFacadeInterface getFacade()
 */
class AllowedProductQuantityCheckoutPreConditionPlugin extends AbstractPlugin implements CheckoutPreConditionPluginInterface
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
    public function checkCondition(QuoteTransfer $quoteTransfer, CheckoutResponseTransfer $checkoutResponseTransfer): bool
    {
        return true;
    }
}
