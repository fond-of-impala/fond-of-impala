<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Dependency\Service;

use DateTime;
use DateTimeInterface;

interface ConditionalAvailabilityCheckoutConnectorToConditionalAvailabilityServiceInterface
{
    /**
     * @param \DateTime $deliveryDate
     *
     * @return \DateTimeInterface
     */
    public function generateLatestOrderDateByDeliveryDate(DateTime $deliveryDate): DateTimeInterface;
}
