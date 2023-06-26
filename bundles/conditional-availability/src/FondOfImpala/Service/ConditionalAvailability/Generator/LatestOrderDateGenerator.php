<?php

namespace FondOfImpala\Service\ConditionalAvailability\Generator;

use DateTime;
use DateTimeInterface;
use FondOfImpala\Service\ConditionalAvailability\ConditionalAvailabilityConfig;

class LatestOrderDateGenerator implements LatestOrderDateGeneratorInterface
{
    protected EarliestOrderDateGeneratorInterface $earliestOrderDateGenerator;

    protected ConditionalAvailabilityConfig $config;

    /**
     * @param \FondOfImpala\Service\ConditionalAvailability\Generator\EarliestOrderDateGeneratorInterface $earliestOrderDateGenerator
     * @param \FondOfImpala\Service\ConditionalAvailability\ConditionalAvailabilityConfig $config
     */
    public function __construct(
        EarliestOrderDateGeneratorInterface $earliestOrderDateGenerator,
        ConditionalAvailabilityConfig $config
    ) {
        $this->earliestOrderDateGenerator = $earliestOrderDateGenerator;
        $this->config = $config;
    }

    /**
     * @param \DateTime $deliveryDate
     *
     * @return \DateTimeInterface
     */
    public function generateByDeliveryDate(DateTime $deliveryDate): DateTimeInterface
    {
        $defaultDeliveryDays = $this->config->getDefaultDeliveryDays();

        $latestOrderDate = clone $deliveryDate;
        $latestOrderDate->setTime(0, 0);

        while ($defaultDeliveryDays > 0) {
            $latestOrderDate->modify('-1day');
            $weekDay = (int)$latestOrderDate->format('N');

            if ($weekDay === 6 || $weekDay === 7) {
                continue;
            }

            $defaultDeliveryDays--;
        }

        return max($latestOrderDate, $this->earliestOrderDateGenerator->generate());
    }
}
