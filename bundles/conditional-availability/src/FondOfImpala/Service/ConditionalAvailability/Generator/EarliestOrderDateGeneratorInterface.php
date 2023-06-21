<?php

namespace FondOfImpala\Service\ConditionalAvailability\Generator;

use DateTimeInterface;

interface EarliestOrderDateGeneratorInterface
{
    /**
     * @return \DateTimeInterface
     */
    public function generate(): DateTimeInterface;
}
