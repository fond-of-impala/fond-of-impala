<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Expander;

use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Reader\ConditionalAvailabilityReaderInterface;
use Generated\Shared\Transfer\QuoteTransfer;

class QuoteExpander implements QuoteExpanderInterface
{
    protected ConditionalAvailabilityReaderInterface $conditionalAvailabilityReader;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Expander\ItemExpanderInterface
     */
    protected ItemExpanderInterface $itemExpander;

    /**
     * @param \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Reader\ConditionalAvailabilityReaderInterface $conditionalAvailabilityReader
     * @param \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Expander\ItemExpanderInterface $itemExpander
     */
    public function __construct(
        ConditionalAvailabilityReaderInterface $conditionalAvailabilityReader,
        ItemExpanderInterface $itemExpander
    ) {
        $this->conditionalAvailabilityReader = $conditionalAvailabilityReader;
        $this->itemExpander = $itemExpander;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function expand(QuoteTransfer $quoteTransfer): QuoteTransfer
    {
        $deliveryDates = [];
        $concreteDeliveryDates = [];
        $groupedConditionalAvailabilities = $this->conditionalAvailabilityReader->getGroupedByQuote($quoteTransfer);

        foreach ($quoteTransfer->getItems() as $itemTransfer) {
            $itemTransfer = $this->itemExpander->expand($itemTransfer, $groupedConditionalAvailabilities);
            $deliveryDate = $itemTransfer->getDeliveryDate();
            $concreteDeliveryDate = $itemTransfer->getConcreteDeliveryDate();
            $deliveryDates[$deliveryDate] = $deliveryDate;

            if ($concreteDeliveryDate === null) {
                continue;
            }

            $concreteDeliveryDates[$concreteDeliveryDate] = $concreteDeliveryDate;
        }

        $quoteTransfer->setDeliveryDates(array_values($deliveryDates))
            ->setConcreteDeliveryDates(array_values($concreteDeliveryDates));

        return $quoteTransfer;
    }
}
