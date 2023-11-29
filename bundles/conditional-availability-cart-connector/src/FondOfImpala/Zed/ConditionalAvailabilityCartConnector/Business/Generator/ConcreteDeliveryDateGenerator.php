<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Business\Generator;

use ArrayObject;
use DateTime;
use DateTimeInterface;
use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Dependency\Service\ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceInterface;
use Generated\Shared\Transfer\ItemTransfer;

class ConcreteDeliveryDateGenerator implements ConcreteDeliveryDateGeneratorInterface
{
    /**
     * @var \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Dependency\Service\ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceInterface
     */
    protected ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceInterface $conditionalAvailabilityService;

    /**
     * @param \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Dependency\Service\ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceInterface $conditionalAvailabilityService
     */
    public function __construct(
        ConditionalAvailabilityCartConnectorToConditionalAvailabilityServiceInterface $conditionalAvailabilityService
    ) {
        $this->conditionalAvailabilityService = $conditionalAvailabilityService;
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
        $concreteDeliveryDate = new DateTime($itemTransfer->getDeliveryDate());
        $latestOrderDate = $this->conditionalAvailabilityService->generateLatestOrderDateByDeliveryDate(
            $concreteDeliveryDate,
        );

        foreach ($conditionalAvailabilityPeriodTransfers as $conditionalAvailabilityPeriodTransfer) {
            $startAt = new DateTime($conditionalAvailabilityPeriodTransfer->getStartAt());
            $endAt = new DateTime($conditionalAvailabilityPeriodTransfer->getEndAt());
            $availableQuantity = $conditionalAvailabilityPeriodTransfer->getQuantity();

            if ($latestOrderDate < $startAt || $latestOrderDate > $endAt || $availableQuantity < $quantity) {
                continue;
            }

            return $concreteDeliveryDate;
        }

        return null;
    }
}
