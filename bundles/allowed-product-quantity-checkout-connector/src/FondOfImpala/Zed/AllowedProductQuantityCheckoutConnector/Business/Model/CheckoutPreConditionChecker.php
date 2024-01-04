<?php

namespace FondOfImpala\Zed\AllowedProductQuantityCheckoutConnector\Business\Model;

use FondOfImpala\Zed\AllowedProductQuantityCheckoutConnector\AllowedProductQuantityCheckoutConnectorConfig;
use FondOfImpala\Zed\AllowedProductQuantityCheckoutConnector\Dependency\Facade\AllowedProductQuantityCheckoutConnectorToAllowedProductQuantityCartConnectorFacadeInterface;
use Generated\Shared\Transfer\CheckoutErrorTransfer;
use Generated\Shared\Transfer\CheckoutResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

class CheckoutPreConditionChecker implements CheckoutPreConditionCheckerInterface
{
    protected AllowedProductQuantityCheckoutConnectorToAllowedProductQuantityCartConnectorFacadeInterface $allowedProductQuantityCartConnectorFacade;

    /**
     * @param \FondOfImpala\Zed\AllowedProductQuantityCheckoutConnector\Dependency\Facade\AllowedProductQuantityCheckoutConnectorToAllowedProductQuantityCartConnectorFacadeInterface $allowedProductQuantityCartConnectorFacade
     */
    public function __construct(
        AllowedProductQuantityCheckoutConnectorToAllowedProductQuantityCartConnectorFacadeInterface $allowedProductQuantityCartConnectorFacade
    ) {
        $this->allowedProductQuantityCartConnectorFacade = $allowedProductQuantityCartConnectorFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\CheckoutResponseTransfer $checkoutResponseTransfer
     *
     * @return bool
     */
    public function check(QuoteTransfer $quoteTransfer, CheckoutResponseTransfer $checkoutResponseTransfer): bool
    {
        $result = true;

        foreach ($quoteTransfer->getItems() as $itemTransfer) {
            $messageTransfers = $this->allowedProductQuantityCartConnectorFacade->validateQuoteItem($itemTransfer);
            $result &= (count($messageTransfers) === 0);
            $this->addViolations($checkoutResponseTransfer, $messageTransfers);
        }

        return $result;
    }

    /**
     * @param \Generated\Shared\Transfer\CheckoutResponseTransfer $checkoutResponseTransfer
     * @param array<\Generated\Shared\Transfer\MessageTransfer> $messageTransfers
     *
     * @return void
     */
    protected function addViolations(CheckoutResponseTransfer $checkoutResponseTransfer, array $messageTransfers): void
    {
        foreach ($messageTransfers as $messageTransfer) {
            $checkoutResponseTransfer->setIsSuccess(false)->addError(
                (new CheckoutErrorTransfer())
                    ->setErrorCode(AllowedProductQuantityCheckoutConnectorConfig::ERROR_CODE_QUOTE_ITEM_INVALID_QUANTITY)
                    ->setMessage($messageTransfer->getValue()),
            );
        }
    }
}
