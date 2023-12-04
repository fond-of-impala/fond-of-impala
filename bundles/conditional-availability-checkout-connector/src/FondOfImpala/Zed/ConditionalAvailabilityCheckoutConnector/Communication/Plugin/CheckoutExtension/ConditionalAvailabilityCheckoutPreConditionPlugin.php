<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Communication\Plugin\CheckoutExtension;

use FondOfImpala\Shared\ConditionalAvailabilityCheckoutConnector\ConditionalAvailabilityCheckoutConnectorConstants;
use Generated\Shared\Transfer\CheckoutErrorTransfer;
use Generated\Shared\Transfer\CheckoutResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Zed\CheckoutExtension\Dependency\Plugin\CheckoutPreConditionPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Communication\ConditionalAvailabilityCheckoutConnectorCommunicationFactory getFactory()
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
        $unavailableSkus = $this->getFactory()
            ->getConditionalAvailabilityCartConnectorFacade()
            ->getUnavailableSkusByQuote($quoteTransfer);

        if (count($unavailableSkus) === 0) {
            return true;
        }

        foreach ($unavailableSkus as $unavailableSku) {
            $checkoutErrorTransfer = (new CheckoutErrorTransfer())
                ->setErrorCode(ConditionalAvailabilityCheckoutConnectorConstants::ERROR_CODE_UNAVAILABLE_PRODUCT)
                ->setMessage(ConditionalAvailabilityCheckoutConnectorConstants::MESSAGE_UNAVAILABLE_PRODUCT)
                ->setErrorType(ConditionalAvailabilityCheckoutConnectorConstants::ERROR_TYPE_CONDITIONAL_AVAILABILITY)
                ->setParameters([
                    ConditionalAvailabilityCheckoutConnectorConstants::PARAMETER_PRODUCT_SKU => $unavailableSku,
                ]);

            $checkoutResponseTransfer
                ->addError($checkoutErrorTransfer)
                ->setIsSuccess(false);
        }

        return false;
    }
}
