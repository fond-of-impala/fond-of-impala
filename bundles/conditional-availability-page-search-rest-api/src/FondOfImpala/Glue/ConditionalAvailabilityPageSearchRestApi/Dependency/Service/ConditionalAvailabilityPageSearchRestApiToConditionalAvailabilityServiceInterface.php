<?php

namespace FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\Dependency\Service;

use DateTime;
use DateTimeInterface;

interface ConditionalAvailabilityPageSearchRestApiToConditionalAvailabilityServiceInterface
{
    /**
     * @param \DateTime $dateTime
     *
     * @return \DateTimeInterface
     */
    public function generateEarliestDeliveryDateByDateTime(DateTime $dateTime): DateTimeInterface;
}
