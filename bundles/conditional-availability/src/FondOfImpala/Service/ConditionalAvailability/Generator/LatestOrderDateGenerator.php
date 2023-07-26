<?php

namespace FondOfImpala\Service\ConditionalAvailability\Generator;

use DateTime;
use DateTimeInterface;
use FondOfImpala\Service\ConditionalAvailability\ConditionalAvailabilityConfig;
use FondOfImpala\Service\ConditionalAvailability\Validator\DateValidatorInterface;

class LatestOrderDateGenerator implements LatestOrderDateGeneratorInterface
{
    protected EarliestOrderDateGeneratorInterface $earliestOrderDateGenerator;

    protected DateValidatorInterface $dateValidator;

    protected ConditionalAvailabilityConfig $config;

    /**
     * @param \FondOfImpala\Service\ConditionalAvailability\Generator\EarliestOrderDateGeneratorInterface $earliestOrderDateGenerator
     * @param \FondOfImpala\Service\ConditionalAvailability\Validator\DateValidatorInterface $dateValidator
     * @param \FondOfImpala\Service\ConditionalAvailability\ConditionalAvailabilityConfig $config
     */
    public function __construct(
        EarliestOrderDateGeneratorInterface $earliestOrderDateGenerator,
        DateValidatorInterface $dateValidator,
        ConditionalAvailabilityConfig $config
    ) {
        $this->earliestOrderDateGenerator = $earliestOrderDateGenerator;
        $this->dateValidator = $dateValidator;
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

            if (!$this->dateValidator->validate($latestOrderDate)) {
                continue;
            }

            $defaultDeliveryDays--;
        }

        return max($latestOrderDate, $this->earliestOrderDateGenerator->generate());
    }
}
