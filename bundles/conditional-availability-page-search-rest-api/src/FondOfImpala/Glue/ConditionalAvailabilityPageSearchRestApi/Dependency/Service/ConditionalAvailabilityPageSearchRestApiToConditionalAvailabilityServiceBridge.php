<?php

namespace FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\Dependency\Service;

use DateTime;
use DateTimeInterface;
use FondOfImpala\Service\ConditionalAvailability\ConditionalAvailabilityServiceInterface;

class ConditionalAvailabilityPageSearchRestApiToConditionalAvailabilityServiceBridge implements
    ConditionalAvailabilityPageSearchRestApiToConditionalAvailabilityServiceInterface
{
    /**
     * @var \FondOfImpala\Service\ConditionalAvailability\ConditionalAvailabilityServiceInterface
     */
    protected $conditionalAvailabilityService;

    /**
     * @param \FondOfImpala\Service\ConditionalAvailability\ConditionalAvailabilityServiceInterface $conditionalAvailabilityService
     */
    public function __construct(ConditionalAvailabilityServiceInterface $conditionalAvailabilityService)
    {
        $this->conditionalAvailabilityService = $conditionalAvailabilityService;
    }

    /**
     * @param \DateTime $dateTime
     *
     * @return \DateTimeInterface
     */
    public function generateEarliestDeliveryDateByDateTime(DateTime $dateTime): DateTimeInterface
    {
        return $this->conditionalAvailabilityService->generateEarliestDeliveryDateByDateTime($dateTime);
    }
}
