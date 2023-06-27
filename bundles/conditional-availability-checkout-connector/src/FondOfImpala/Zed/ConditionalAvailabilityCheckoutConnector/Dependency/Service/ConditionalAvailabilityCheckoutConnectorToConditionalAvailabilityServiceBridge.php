<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Dependency\Service;

use DateTime;
use DateTimeInterface;
use FondOfImpala\Service\ConditionalAvailability\ConditionalAvailabilityServiceInterface;

class ConditionalAvailabilityCheckoutConnectorToConditionalAvailabilityServiceBridge implements
    ConditionalAvailabilityCheckoutConnectorToConditionalAvailabilityServiceInterface
{
    protected ConditionalAvailabilityServiceInterface $conditionalAvailabilityService;

    /**
     * @param \FondOfImpala\Service\ConditionalAvailability\ConditionalAvailabilityServiceInterface $conditionalAvailabilityService
     */
    public function __construct(ConditionalAvailabilityServiceInterface $conditionalAvailabilityService)
    {
        $this->conditionalAvailabilityService = $conditionalAvailabilityService;
    }

    /**
     * @param \DateTime $deliveryDate
     *
     * @return \DateTimeInterface
     */
    public function generateLatestOrderDateByDeliveryDate(DateTime $deliveryDate): DateTimeInterface
    {
        return $this->conditionalAvailabilityService->generateLatestOrderDateByDeliveryDate($deliveryDate);
    }
}
