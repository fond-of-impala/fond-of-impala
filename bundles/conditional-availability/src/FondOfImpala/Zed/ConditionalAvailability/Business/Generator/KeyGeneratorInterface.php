<?php

namespace FondOfImpala\Zed\ConditionalAvailability\Business\Generator;

use DateTime;
use Generated\Shared\Transfer\ConditionalAvailabilityPeriodTransfer;

interface KeyGeneratorInterface
{
    /**
     * @param \Generated\Shared\Transfer\ConditionalAvailabilityPeriodTransfer $conditionalAvailabilityPeriod
     * @param \DateTime|null $dateTime
     *
     * @return string
     */
    public function generate(
        ConditionalAvailabilityPeriodTransfer $conditionalAvailabilityPeriod,
        ?DateTime $dateTime = null
    ): string;
}
