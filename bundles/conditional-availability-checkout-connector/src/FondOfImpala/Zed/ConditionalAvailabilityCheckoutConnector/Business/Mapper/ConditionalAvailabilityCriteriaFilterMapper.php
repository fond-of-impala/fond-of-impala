<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Business\Mapper;

use FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Business\Reader\CustomerReaderInterface;
use Generated\Shared\Transfer\ConditionalAvailabilityCriteriaFilterTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

class ConditionalAvailabilityCriteriaFilterMapper implements ConditionalAvailabilityCriteriaFilterMapperInterface
{
    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Business\Reader\CustomerReaderInterface
     */
    protected CustomerReaderInterface $customerReader;

    /**
     * @param \FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Business\Reader\CustomerReaderInterface $customerReader
     */
    public function __construct(CustomerReaderInterface $customerReader)
    {
        $this->customerReader = $customerReader;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\ConditionalAvailabilityCriteriaFilterTransfer|null
     */
    public function fromQuote(QuoteTransfer $quoteTransfer): ?ConditionalAvailabilityCriteriaFilterTransfer
    {
        $customerTransfer = $this->customerReader->getByQuote($quoteTransfer);

        if ($customerTransfer === null || $customerTransfer->getAvailabilityChannel() === null) {
            return null;
        }

        return (new ConditionalAvailabilityCriteriaFilterTransfer())
            ->setMinimumQuantity(1)
            ->setWarehouseGroup('EU')
            ->setChannel($customerTransfer->getAvailabilityChannel());
    }
}
