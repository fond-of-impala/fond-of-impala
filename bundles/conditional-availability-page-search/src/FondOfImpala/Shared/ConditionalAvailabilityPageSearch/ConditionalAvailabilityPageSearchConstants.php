<?php

namespace FondOfImpala\Shared\ConditionalAvailabilityPageSearch;

interface ConditionalAvailabilityPageSearchConstants
{
    /**
     * @var string
     */
    public const CONDITIONAL_AVAILABILITY_SEARCH_QUEUE = 'sync.search.conditional_availability';

    /**
     * @var string
     */
    public const CONDITIONAL_AVAILABILITY_SEARCH_ERROR_QUEUE = 'sync.search.conditional_availability.error';

    /**
     * @var string
     */
    public const CONDITIONAL_AVAILABILITY_PERIOD_RESOURCE_NAME = 'conditional_availability_period';

    /**
     * @var string
     */
    public const PARAMETER_SKU = 'sku';

    /**
     * @var string
     */
    public const PARAMETER_END_AT = 'end-at';

    /**
     * @var string
     */
    public const PARAMETER_START_AT = 'start-at';

    /**
     * @var string
     */
    public const PARAMETER_WAREHOUSE_GROUP = 'warehouse-group';

    /**
     * @var string
     */
    public const PARAMETER_CHANNEL = 'channel';

    /**
     * @var string
     */
    public const PARAMETER_ONE_PER_SKU = 'one-per-sku';

    /**
     * @var string
     */
    public const PARAMETER_MIN_QTY = 'min-qty';
}
