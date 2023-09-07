<?php

namespace FondOfImpala\Shared\ConditionalAvailabilitySearch;

use Spryker\Shared\Kernel\AbstractBundleConfig;

class ConditionalAvailabilitySearchConfig extends AbstractBundleConfig
{
    /**
     * @var string
     */
    public const PLUGIN_CONDITIONAL_AVAILABILITY_DATA = 'PLUGIN_CONDITIONAL_AVAILABILITY_DATA';

    /**
     * Specification:
     *  - Conditional Availability resource name, used for key generation.
     *
     * @api
     *
     * @var string
     */
    public const CONDITIONAL_AVAILABILITY_RESOURCE_NAME = 'conditional_availability_search';
}
