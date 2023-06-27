<?php

namespace FondOfImpala\Service\ConditionalAvailability\Generator;

use DateTime;
use DateTimeInterface;
use FondOfImpala\Service\ConditionalAvailability\ConditionalAvailabilityConfig;

class EarliestDeliveryDateGenerator implements EarliestDeliveryDateGeneratorInterface
{
    protected ConditionalAvailabilityConfig $config;

    /**
     * @param \FondOfImpala\Service\ConditionalAvailability\ConditionalAvailabilityConfig $config
     */
    public function __construct(ConditionalAvailabilityConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @codeCoverageIgnore
     *
     * @return \DateTimeInterface
     */
    public function generate(): DateTimeInterface
    {
        return $this->generateByDateTime(new DateTime());
    }

    /**
     * @param \DateTime $dateTime
     *
     * @return \DateTimeInterface
     */
    public function generateByDateTime(DateTime $dateTime): DateTimeInterface
    {
        $defaultDeliveryDays = $this->config->getDefaultDeliveryDays();

        $dateTime->setTime(0, 0);

        while ($defaultDeliveryDays > 0) {
            $dateTime->modify('+1day');
            $weekDay = (int)$dateTime->format('N');

            if ($weekDay === 6 || $weekDay === 7) {
                continue;
            }

            $defaultDeliveryDays--;
        }

        return $dateTime;
    }
}
