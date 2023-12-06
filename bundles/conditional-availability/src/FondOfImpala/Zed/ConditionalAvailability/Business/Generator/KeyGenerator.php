<?php

namespace FondOfImpala\Zed\ConditionalAvailability\Business\Generator;

use DateTime;
use Generated\Shared\Transfer\ConditionalAvailabilityPeriodTransfer;

class KeyGenerator implements KeyGeneratorInterface
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
    ): string {
        $dateTime = $dateTime ?? new DateTime();

        $keyParts = [
            $conditionalAvailabilityPeriod->getFkConditionalAvailability(),
            $conditionalAvailabilityPeriod->getStartAt(),
            $conditionalAvailabilityPeriod->getEndAt(),
            $dateTime->format('Y-m-d H:i:s.u'),
        ];

        return sha1(implode(':', $keyParts));
    }
}
