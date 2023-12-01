<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Generator;

use DateTime;
use DateTimeInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Dependency\Service\ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceInterface;
use Generated\Shared\Transfer\ConditionalAvailabilityPeriodTransfer;
use Generated\Shared\Transfer\ItemTransfer;

class DeliveryDateGenerator implements DeliveryDateGeneratorInterface
{
    /**
     * @var string
     */
    protected const FORMAT = 'Y-m-d';

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
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     *
     * @return string
     */
    public function generateConcreteByItem(ItemTransfer $itemTransfer): string
    {
        return (new DateTime($itemTransfer->getDeliveryDate()))->format(static::FORMAT);
    }

    /**
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityPeriodTransfer $conditionalAvailabilityPeriodTransfer
     *
     * @return string
     */
    public function generateEarliestByConditionalAvailabilityPeriod(
        ConditionalAvailabilityPeriodTransfer $conditionalAvailabilityPeriodTransfer
    ): string {
        $startAt = new DateTime($conditionalAvailabilityPeriodTransfer->getStartAt());

        if ($startAt <= $this->today) {
            return ($this->earliestDeliveryDate)->format(static::FORMAT);
        }

        return $this->conditionalAvailabilityService
            ->generateEarliestDeliveryDateByDateTime($startAt)
            ->format(static::FORMAT);
    }
}
