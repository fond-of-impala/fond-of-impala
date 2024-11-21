<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Expander;

use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Generator\DeliveryDateGeneratorInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Reader\ConditionalAvailabilityReaderInterface;
use Generated\Shared\Transfer\QuoteTransfer;

class QuoteExpander implements QuoteExpanderInterface
{
    protected ConditionalAvailabilityReaderInterface $conditionalAvailabilityReader;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Expander\ItemExpanderInterface
     */
    protected ItemExpanderInterface $itemExpander;

    protected DeliveryDateGeneratorInterface $deliveryDateGenerator;

    /**
     * @param \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Reader\ConditionalAvailabilityReaderInterface $conditionalAvailabilityReader
     * @param \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Expander\ItemExpanderInterface $itemExpander
     * @param \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Generator\DeliveryDateGeneratorInterface $deliveryDateGenerator
     */
    public function __construct(
        ConditionalAvailabilityReaderInterface $conditionalAvailabilityReader,
        ItemExpanderInterface $itemExpander,
        DeliveryDateGeneratorInterface $deliveryDateGenerator
    ) {
        $this->conditionalAvailabilityReader = $conditionalAvailabilityReader;
        $this->itemExpander = $itemExpander;
        $this->deliveryDateGenerator = $deliveryDateGenerator;
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
            $deliveryDates[$deliveryDate] = $this->deliveryDateGenerator->addWorkingDayThreshold($deliveryDate);

            if ($concreteDeliveryDate === null) {
                continue;
            }
            $concreteDeliveryDates[$concreteDeliveryDate] = $this->deliveryDateGenerator->addWorkingDayThreshold($concreteDeliveryDate);
        }

        $quoteTransfer->setDeliveryDates(array_values($deliveryDates))
            ->setConcreteDeliveryDates(array_values($concreteDeliveryDates));

        return $quoteTransfer;
    }
}
