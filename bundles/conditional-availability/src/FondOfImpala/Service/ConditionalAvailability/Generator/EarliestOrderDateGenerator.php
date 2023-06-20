<?php

namespace FondOfImpala\Service\ConditionalAvailability\Generator;

use DateTime;
use DateTimeInterface;

class EarliestOrderDateGenerator implements EarliestOrderDateGeneratorInterface
{
    /**
     * @return \DateTimeInterface
     */
    public function generate(): DateTimeInterface
    {
        return (new DateTime())->setTime(0, 0);
    }
}
