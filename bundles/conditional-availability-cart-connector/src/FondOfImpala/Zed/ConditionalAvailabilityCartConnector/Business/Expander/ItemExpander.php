<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Expander;

use ArrayObject;
use FondOfImpala\Shared\ConditionalAvailability\ConditionalAvailabilityConstants;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Filter\ConditionalAvailabilityPeriodsFilterInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Finder\IndexFinderInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Generator\DeliveryDateGeneratorInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Generator\MessageGeneratorInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Reducer\ConditionalAvailabilityPeriodsReducerInterface;
use Generated\Shared\Transfer\ItemTransfer;

class ItemExpander implements ItemExpanderInterface
{
    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Filter\ConditionalAvailabilityPeriodsFilterInterface
     */
    protected ConditionalAvailabilityPeriodsFilterInterface $conditionalAvailabilityPeriodsFilter;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Finder\IndexFinderInterface
     */
    protected IndexFinderInterface $indexFinder;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Generator\MessageGeneratorInterface
     */
    protected MessageGeneratorInterface $messageGenerator;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Reducer\ConditionalAvailabilityPeriodsReducerInterface
     */
    protected ConditionalAvailabilityPeriodsReducerInterface $conditionalAvailabilityPeriodsReducer;

    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Generator\DeliveryDateGeneratorInterface
     */
    protected DeliveryDateGeneratorInterface $deliveryDateGenerator;

    /**
     * @param \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Filter\ConditionalAvailabilityPeriodsFilterInterface $conditionalAvailabilityPeriodsFilter
     * @param \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Finder\IndexFinderInterface $indexFinder
     * @param \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Generator\MessageGeneratorInterface $messageGenerator
     * @param \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Generator\DeliveryDateGeneratorInterface $deliveryDateGenerator
     * @param \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Reducer\ConditionalAvailabilityPeriodsReducerInterface $conditionalAvailabilityPeriodsReducer
     */
    public function __construct(
        ConditionalAvailabilityPeriodsFilterInterface $conditionalAvailabilityPeriodsFilter,
        IndexFinderInterface $indexFinder,
        MessageGeneratorInterface $messageGenerator,
        DeliveryDateGeneratorInterface $deliveryDateGenerator,
        ConditionalAvailabilityPeriodsReducerInterface $conditionalAvailabilityPeriodsReducer
    ) {
        $this->conditionalAvailabilityPeriodsFilter = $conditionalAvailabilityPeriodsFilter;
        $this->indexFinder = $indexFinder;
        $this->messageGenerator = $messageGenerator;
        $this->deliveryDateGenerator = $deliveryDateGenerator;
        $this->conditionalAvailabilityPeriodsReducer = $conditionalAvailabilityPeriodsReducer;
    }

    /**
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     * @param \ArrayObject<string, \ArrayObject<\Generated\Shared\Transfer\ConditionalAvailabilityTransfer>> $groupedConditionalAvailabilities
     *
     * @return \Generated\Shared\Transfer\ItemTransfer
     */
    public function expand(
        ItemTransfer $itemTransfer,
        ArrayObject $groupedConditionalAvailabilities
    ): ItemTransfer {
        if ($itemTransfer->getDeliveryDate() === ConditionalAvailabilityConstants::KEY_EARLIEST_DATE) {
            return $this->expandEarliest($itemTransfer, $groupedConditionalAvailabilities);
        }

        return $this->expandConcrete($itemTransfer, $groupedConditionalAvailabilities);
    }

    /**
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     * @param \ArrayObject<string, \ArrayObject<\Generated\Shared\Transfer\ConditionalAvailabilityTransfer>> $groupedConditionalAvailabilities
     *
     * @return \Generated\Shared\Transfer\ItemTransfer
     */
    protected function expandEarliest(
        ItemTransfer $itemTransfer,
        ArrayObject $groupedConditionalAvailabilities
    ): ItemTransfer {
        $conditionalAvailabilityPeriodTransfers = $this->conditionalAvailabilityPeriodsFilter
            ->filterFromGroupedConditionalAvailabilitiesByItem(
                $groupedConditionalAvailabilities,
                $itemTransfer,
            );

        if ($conditionalAvailabilityPeriodTransfers === null) {
            return $itemTransfer->addValidationMessage(
                $this->messageGenerator->createNotAvailableForEarliestDeliveryDateMessage(),
            );
        }

        $index = $this->indexFinder->findEarliestFromConditionalAvailabilityPeriods(
            $conditionalAvailabilityPeriodTransfers,
            $itemTransfer,
        );

        if ($index === null) {
            return $itemTransfer->addValidationMessage($this->messageGenerator->createNotAvailableForGivenQytMessage());
        }

        $this->conditionalAvailabilityPeriodsReducer->reduceByItemAndEffectedIndex(
            $conditionalAvailabilityPeriodTransfers,
            $itemTransfer,
            $index,
        );

        $earliestDeliveryDate = $this->deliveryDateGenerator->generateEarliestByConditionalAvailabilityPeriod(
            $conditionalAvailabilityPeriodTransfers->offsetGet($index),
        );

        return $itemTransfer->setDeliveryDate(ConditionalAvailabilityConstants::KEY_EARLIEST_DATE)
            ->setConcreteDeliveryDate($earliestDeliveryDate);
    }

    /**
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     * @param \ArrayObject<string, \ArrayObject<\Generated\Shared\Transfer\ConditionalAvailabilityTransfer>> $groupedConditionalAvailabilities
     *
     * @return \Generated\Shared\Transfer\ItemTransfer
     */
    protected function expandConcrete(
        ItemTransfer $itemTransfer,
        ArrayObject $groupedConditionalAvailabilities
    ): ItemTransfer {
        $conditionalAvailabilityPeriodTransfers = $this->conditionalAvailabilityPeriodsFilter
            ->filterFromGroupedConditionalAvailabilitiesByItem(
                $groupedConditionalAvailabilities,
                $itemTransfer,
            );

        if ($conditionalAvailabilityPeriodTransfers === null) {
            return $itemTransfer->addValidationMessage(
                $this->messageGenerator->createNotAvailableForGivenDeliveryDateMessage(),
            );
        }

        $index = $this->indexFinder->findConcreteFromConditionalAvailabilityPeriods(
            $conditionalAvailabilityPeriodTransfers,
            $itemTransfer,
        );

        if ($index === null) {
            return $itemTransfer->addValidationMessage($this->messageGenerator->createNotAvailableForGivenQytMessage());
        }

        $this->conditionalAvailabilityPeriodsReducer->reduceByItemAndEffectedIndex(
            $conditionalAvailabilityPeriodTransfers,
            $itemTransfer,
            $index,
        );

        $concreteDeliveryDate = $this->deliveryDateGenerator->generateConcreteByItem($itemTransfer);

        return $itemTransfer->setDeliveryDate($concreteDeliveryDate)
            ->setConcreteDeliveryDate($concreteDeliveryDate);
    }
}
