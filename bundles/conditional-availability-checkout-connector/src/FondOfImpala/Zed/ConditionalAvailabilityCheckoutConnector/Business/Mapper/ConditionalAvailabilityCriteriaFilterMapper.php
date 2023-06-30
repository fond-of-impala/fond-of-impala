<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Business\Mapper;

use Generated\Shared\Transfer\ConditionalAvailabilityCriteriaFilterTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

class ConditionalAvailabilityCriteriaFilterMapper implements ConditionalAvailabilityCriteriaFilterMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\ConditionalAvailabilityCriteriaFilterTransfer|null
     */
    public function fromQuote(QuoteTransfer $quoteTransfer): ?ConditionalAvailabilityCriteriaFilterTransfer
    {
        $customerTransfer = $quoteTransfer->getCustomer();

        if ($customerTransfer === null || $customerTransfer->getAvailabilityChannel() === null) {
            return null;
        }

        return (new ConditionalAvailabilityCriteriaFilterTransfer())
            ->setMinimumQuantity(1)
            ->setWarehouseGroup('EU')
            ->setChannel($customerTransfer->getAvailabilityChannel());
    }
}
