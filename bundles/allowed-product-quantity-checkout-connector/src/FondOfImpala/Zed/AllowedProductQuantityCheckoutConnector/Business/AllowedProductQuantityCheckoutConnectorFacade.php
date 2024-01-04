<?php

namespace FondOfImpala\Zed\AllowedProductQuantityCheckoutConnector\Business;

use Generated\Shared\Transfer\CheckoutResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfImpala\Zed\AllowedProductQuantityCheckoutConnector\Business\AllowedProductQuantityCheckoutConnectorBusinessFactory getFactory()
 */
class AllowedProductQuantityCheckoutConnectorFacade extends AbstractFacade implements AllowedProductQuantityCheckoutConnectorFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\CheckoutResponseTransfer $checkoutResponseTransfer
     *
     * @return bool
     */
    public function checkCheckoutPreCondition(QuoteTransfer $quoteTransfer, CheckoutResponseTransfer $checkoutResponseTransfer): bool
    {
        return $this->getFactory()->createCheckoutPreConditionChecker()
            ->check($quoteTransfer, $checkoutResponseTransfer);
    }
}
