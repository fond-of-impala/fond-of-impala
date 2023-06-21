<?php

namespace FondOfImpala\Zed\ConditionalAvailability\Dependency;

interface ConditionalAvailabilityEvents
{
    /**
     * Specification:
     * - This event will be used for foi_conditional_availability entity creation
     *
     * @api
     *
     * @var string
     */
    public const ENTITY_FOI_CONDITIONAL_AVAILABILITY_CREATE = 'Entity.foi_conditional_availability.create';

    /**
     * Specification:
     * - This event will be used for foi_price_product_price_list entity update
     *
     * @api
     *
     * @var string
     */
    public const ENTITY_FOI_CONDITIONAL_AVAILABILITY_UPDATE = 'Entity.foi_conditional_availability.update';

    /**
     * Specification:
     * - This event will be used for foi_price_product_price_list entity delete
     *
     * @api
     *
     * @var string
     */
    public const ENTITY_FOI_CONDITIONAL_AVAILABILITY_DELETE = 'Entity.foi_conditional_availability.delete';

    /**
     * Specification
     * - This events will be used for conditional_availability publishing
     *
     * @api
     *
     * @var string
     */
    public const CONDITIONAL_AVAILABILITY_PUBLISH = 'ConditionalAvailability.conditional_availability.publish';

    /**
     * Specification
     * - This events will be used for conditional_availability un-publishing
     *
     * @api
     *
     * @var string
     */
    public const CONDITIONAL_AVAILABILITY_UNPUBLISH = 'ConditionalAvailability.conditional_availability.unpublish';

    /**
     * Specification:
     * - This event will be used for foi_conditional_availability entity creation
     *
     * @api
     *
     * @var string
     */
    public const ENTITY_FOI_CONDITIONAL_AVAILABILITY_PERIOD_CREATE = 'Entity.foi_conditional_availability_period.create';

    /**
     * Specification:
     * - This event will be used for foi_price_product_price_list entity update
     *
     * @api
     *
     * @var string
     */
    public const ENTITY_FOI_CONDITIONAL_AVAILABILITY_PERIOD_UPDATE = 'Entity.foi_conditional_availability_period.update';

    /**
     * Specification:
     * - This event will be used for foi_price_product_price_list entity delete
     *
     * @api
     *
     * @var string
     */
    public const ENTITY_FOI_CONDITIONAL_AVAILABILITY_PERIOD_DELETE = 'Entity.foi_conditional_availability_period.delete';

    /**
     * Specification
     * - This events will be used for conditional_availability publishing
     *
     * @api
     *
     * @var string
     */
    public const CONDITIONAL_AVAILABILITY_PERIOD_PUBLISH = 'ConditionalAvailability.conditional_availability_period.publish';

    /**
     * Specification
     * - This events will be used for conditional_availability un-publishing
     *
     * @api
     *
     * @var string
     */
    public const CONDITIONAL_AVAILABILITY_PERIOD_UNPUBLISH = 'ConditionalAvailability.conditional_availability_period.unpublish';
}
