<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Generator;

use ArrayObject;
use DateTime;
use DateTimeInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Dependency\Service\ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceInterface;
use Generated\Shared\Transfer\ItemTransfer;

class EarliestDeliveryDateGenerator implements EarliestDeliveryDateGeneratorInterface
{
    protected ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceInterface $conditionalAvailabilityService;

    protected DateTimeInterface $today;

    protected DateTimeInterface $earliestDeliveryDate;

    /**
     * @param \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Dependency\Service\ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceInterface $conditionalAvailabilityService
     */
    public function __construct(
        ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceInterface $conditionalAvailabilityService
    ) {
        $this->today = new DateTime();
        $this->conditionalAvailabilityService = $conditionalAvailabilityService;
        $this->earliestDeliveryDate = $this->conditionalAvailabilityService->generateEarliestDeliveryDate();
    }

    /**
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     * @param \ArrayObject $conditionalAvailabilityPeriodTransfers
     *
     * @return \DateTimeInterface|null
     */
    public function generateByItemAndConditionalAvailabilityPeriods(
        ItemTransfer $itemTransfer,
        ArrayObject $conditionalAvailabilityPeriodTransfers
    ): ?DateTimeInterface {
        $quantity = $itemTransfer->getQuantity();

        foreach ($conditionalAvailabilityPeriodTransfers as $conditionalAvailabilityPeriodTransfer) {
            $startAt = new DateTime($conditionalAvailabilityPeriodTransfer->getStartAt());
            $endAt = new DateTime($conditionalAvailabilityPeriodTransfer->getEndAt());
            $availableQuantity = $conditionalAvailabilityPeriodTransfer->getQuantity();

            if ($this->today > $endAt || $availableQuantity <= 0) {
                continue;
            }

            if ($availableQuantity < $quantity) {
                return null;
            }

            if ($startAt <= $this->today) {
                return $this->earliestDeliveryDate;
            }

            return $this->conditionalAvailabilityService
                ->generateEarliestDeliveryDateByDateTime($startAt);
        }

        return null;
    }
}
