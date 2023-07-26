<?php

namespace FondOfImpala\Service\ConditionalAvailability\Generator;

use DateTime;
use DateTimeInterface;
use FondOfImpala\Service\ConditionalAvailability\ConditionalAvailabilityConfig;
use FondOfImpala\Service\ConditionalAvailability\Validator\DateValidatorInterface;

class EarliestDeliveryDateGenerator implements EarliestDeliveryDateGeneratorInterface
{
    protected DateValidatorInterface $dateValidator;

    protected ConditionalAvailabilityConfig $config;

    /**
     * @param \FondOfImpala\Service\ConditionalAvailability\Validator\DateValidatorInterface $dateValidator
     * @param \FondOfImpala\Service\ConditionalAvailability\ConditionalAvailabilityConfig $config
     */
    public function __construct(
        DateValidatorInterface $dateValidator,
        ConditionalAvailabilityConfig $config
    ) {
        $this->dateValidator = $dateValidator;
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

        if (!$this->dateValidator->validate($dateTime)) {
            $defaultDeliveryDays++;
        }

        while ($defaultDeliveryDays > 0) {
            $dateTime->modify('+1day');

            if (!$this->dateValidator->validate($dateTime)) {
                continue;
            }

            $defaultDeliveryDays--;
        }

        return $dateTime;
    }
}
