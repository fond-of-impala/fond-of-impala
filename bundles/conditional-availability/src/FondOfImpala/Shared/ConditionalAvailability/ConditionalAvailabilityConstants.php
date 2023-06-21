<?php

declare(strict_types = 1);

namespace FondOfImpala\Shared\ConditionalAvailability;

interface ConditionalAvailabilityConstants
{
    /**
     * @var string
     */
    public const KEY_EARLIEST_DATE = 'earliest-date';

    /**
     * @var string
     */
    public const DEFAULT_DELIVERY_DAYS = 'FOND_OF_SPRYKER:CONDITIONAL_AVAILABILITY:DEFAULT_DELIVERY_DAYS';

    /**
     * @var int
     */
    public const DEFAULT_VALUE_DEFAULT_DELIVERY_DAYS = 2;
}
