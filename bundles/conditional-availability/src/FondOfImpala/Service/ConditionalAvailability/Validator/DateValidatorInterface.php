<?php

namespace FondOfImpala\Service\ConditionalAvailability\Validator;

use DateTime;

interface DateValidatorInterface
{
    /**
     * @param \DateTime $date
     *
     * @return bool
     */
    public function validate(DateTime $date): bool;
}
