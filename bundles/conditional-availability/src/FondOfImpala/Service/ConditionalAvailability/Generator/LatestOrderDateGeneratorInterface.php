<?php

namespace FondOfImpala\Service\ConditionalAvailability\Generator;

use DateTime;
use DateTimeInterface;

interface LatestOrderDateGeneratorInterface
{
    /**
     * @param \DateTime $deliveryDate
     *
     * @return \DateTimeInterface
     */
    public function generateByDeliveryDate(DateTime $deliveryDate): DateTimeInterface;
}
