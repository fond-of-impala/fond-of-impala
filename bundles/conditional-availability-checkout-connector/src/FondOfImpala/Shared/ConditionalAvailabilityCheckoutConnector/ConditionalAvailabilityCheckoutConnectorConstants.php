<?php

namespace FondOfImpala\Shared\ConditionalAvailabilityCheckoutConnector;

interface ConditionalAvailabilityCheckoutConnectorConstants
{
    /**
     * @var string
     */
    public const ERROR_TYPE_CONDITIONAL_AVAILABILITY = 'Conditional Availability';

    /**
     * @var string
     */
    public const MESSAGE_UNAVAILABLE_PRODUCT = 'conditional_availability_checkout_connector.product.unavailable';

    /**
     * @var int
     */
    public const ERROR_CODE_UNAVAILABLE_PRODUCT = 4102;

    /**
     * @var string
     */
    public const PARAMETER_PRODUCT_SKU = '%sku%';
}
