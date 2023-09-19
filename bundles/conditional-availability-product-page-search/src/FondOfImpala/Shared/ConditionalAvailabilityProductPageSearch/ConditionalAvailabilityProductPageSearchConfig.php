<?php

namespace FondOfImpala\Shared\ConditionalAvailabilityProductPageSearch;

use Spryker\Shared\Kernel\AbstractBundleConfig;

class ConditionalAvailabilityProductPageSearchConfig extends AbstractBundleConfig
{
    /**
     * @var string
     */
    public const PLUGIN_STOCK_STATUS_DATA = 'PLUGIN_STOCK_STATUS_DATA';

    /**
     * Specification:
     *  - Conditional Availability resource name, used for key generation.
     *
     * @api
     *
     * @var string
     */
    public const CONDITIONAL_AVAILABILITY_RESOURCE_NAME = 'conditional_availability_product_page_search';

    /**
     * @var int
     */
    public const STOCK_STATUS_IN_STOCK = 2;

    /**
     * @var int
     */
    public const STOCK_STATUS_LATER_IN_STOCK = 1;

    /**
     * @var int
     */
    public const STOCK_STATUS_OUT_OF_STOCK = 0;
}
