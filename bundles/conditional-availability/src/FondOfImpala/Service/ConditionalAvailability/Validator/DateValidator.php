<?php

namespace FondOfImpala\Service\ConditionalAvailability\Validator;

use DateTime;

class DateValidator implements DateValidatorInterface
{
    /**
     * @param \DateTime $date
     *
     * @return bool
     */
    public function validate(DateTime $date): bool
    {
        $weekDay = (int)$date->format('N');

        return $weekDay !== 6 && $weekDay !== 7;
    }
}
