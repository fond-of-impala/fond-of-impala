<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Generator;

use DateTime;
use DateTimeInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\ConditionalAvailabilityCartConnectorConfig;
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

    protected ConditionalAvailabilityCartConnectorConfig $config;

    protected ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceInterface $conditionalAvailabilityService;

    /**
     * @param \DateTimeInterface $today
     * @param \DateTimeInterface $earliestDeliveryDate
     * @param \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Dependency\Service\ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceInterface $conditionalAvailabilityService
     * @param \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\ConditionalAvailabilityCartConnectorConfig $config
     */
    public function __construct(
        DateTimeInterface $today,
        DateTimeInterface $earliestDeliveryDate,
        ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceInterface $conditionalAvailabilityService,
        ConditionalAvailabilityCartConnectorConfig $config
    ) {
        $this->today = $today;
        $this->earliestDeliveryDate = $earliestDeliveryDate;
        $this->conditionalAvailabilityService = $conditionalAvailabilityService;
        $this->config = $config;
    }

    /**
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     *
     * @return string
     */
    public function generateConcreteByItem(ItemTransfer $itemTransfer): string
    {
        return (new DateTime($this->addWorkingDayThreshold($itemTransfer->getDeliveryDate())))->format(static::FORMAT);
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
            return $this->addWorkingDayThreshold(($this->earliestDeliveryDate)->format(static::FORMAT));
        }

        $deliveryDate = $this->conditionalAvailabilityService
            ->generateEarliestDeliveryDateByDateTime($startAt)
            ->format(static::FORMAT);

        return $this->addWorkingDayThreshold($deliveryDate);
    }

    /**
     * @param string|null $deliveryDate
     *
     * @return string|null
     */
    public function addWorkingDayThreshold(?string $deliveryDate): ?string
    {
        if (
            $deliveryDate === null
            || strtotime($deliveryDate) === false
            || $this->config->getDeliveryTimeThreshold() === null
        ) {
            return $deliveryDate;
        }

        return date('Y-m-d', strtotime($deliveryDate . ' ' . $this->config->getDeliveryTimeThreshold()));
    }
}
