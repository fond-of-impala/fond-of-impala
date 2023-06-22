<?php

declare (strict_types = 1);

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Model;

use Generated\Shared\Transfer\QuoteTransfer;

class ConditionalAvailabilityDeliveryDateCleaner implements ConditionalAvailabilityDeliveryDateCleanerInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function cleanDeliveryDate(QuoteTransfer $quoteTransfer): QuoteTransfer
    {
        $quoteTransfer = $this->clearDeliveryDatesOnEmptyCartItems($quoteTransfer);

        return $quoteTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    protected function clearDeliveryDatesOnEmptyCartItems(QuoteTransfer $quoteTransfer): QuoteTransfer
    {
        if ($quoteTransfer->getItems()->count() !== 0) {
            return $quoteTransfer;
        }

        $quoteTransfer->setDeliveryDates();
        $quoteTransfer->setConcreteDeliveryDates();

        return $quoteTransfer;
    }
}
