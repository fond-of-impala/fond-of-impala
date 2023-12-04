<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Finder;

use ArrayObject;
use DateTime;
use DateTimeInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Dependency\Service\ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceInterface;
use Generated\Shared\Transfer\ItemTransfer;

class IndexFinder implements IndexFinderInterface
{
    protected DateTimeInterface $today;

    protected DateTimeInterface $earliestDeliveryDate;

    protected ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceInterface $conditionalAvailabilityService;

    /**
     * @param \DateTimeInterface $today
     * @param \DateTimeInterface $earliestDeliveryDate
     * @param \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Dependency\Service\ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceInterface $conditionalAvailabilityService
     */
    public function __construct(
        DateTimeInterface $today,
        DateTimeInterface $earliestDeliveryDate,
        ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceInterface $conditionalAvailabilityService
    ) {
        $this->today = $today;
        $this->earliestDeliveryDate = $earliestDeliveryDate;
        $this->conditionalAvailabilityService = $conditionalAvailabilityService;
    }

    /**
     * @param \ArrayObject $conditionalAvailabilityPeriodTransfers
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     *
     * @return int|null
     */
    public function findEarliestFromConditionalAvailabilityPeriods(
        ArrayObject $conditionalAvailabilityPeriodTransfers,
        ItemTransfer $itemTransfer
    ): ?int {
        $quantity = $itemTransfer->getQuantity();

        foreach ($conditionalAvailabilityPeriodTransfers as $index => $conditionalAvailabilityPeriodTransfer) {
            $endAt = new DateTime($conditionalAvailabilityPeriodTransfer->getEndAt());
            $availableQuantity = $conditionalAvailabilityPeriodTransfer->getQuantity();

            if ($this->today > $endAt || $availableQuantity <= 0) {
                continue;
            }

            if ($availableQuantity < $quantity) {
                return null;
            }

            return $index;
        }

        return null;
    }

    /**
     * @param \ArrayObject<\Generated\Shared\Transfer\ConditionalAvailabilityPeriodTransfer> $conditionalAvailabilityPeriodTransfers
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     *
     * @return int|null
     */
    public function findConcreteFromConditionalAvailabilityPeriods(
        ArrayObject $conditionalAvailabilityPeriodTransfers,
        ItemTransfer $itemTransfer
    ): ?int {
        $quantity = $itemTransfer->getQuantity();
        $concreteDeliveryDate = new DateTime($itemTransfer->getConcreteDeliveryDate() ?? $itemTransfer->getDeliveryDate());
        $latestOrderDate = $this->conditionalAvailabilityService->generateLatestOrderDateByDeliveryDate(
            $concreteDeliveryDate,
        );

        foreach ($conditionalAvailabilityPeriodTransfers as $index => $conditionalAvailabilityPeriodTransfer) {
            $startAt = new DateTime($conditionalAvailabilityPeriodTransfer->getStartAt());
            $endAt = new DateTime($conditionalAvailabilityPeriodTransfer->getEndAt());
            $availableQuantity = $conditionalAvailabilityPeriodTransfer->getQuantity();

            if ($latestOrderDate < $startAt || $latestOrderDate > $endAt || $availableQuantity < $quantity) {
                continue;
            }

            return $index;
        }

        return null;
    }
}
