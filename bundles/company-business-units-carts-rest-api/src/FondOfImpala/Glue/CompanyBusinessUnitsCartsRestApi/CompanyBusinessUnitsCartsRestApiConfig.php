<?php

namespace FondOfImpala\Glue\CompanyBusinessUnitsCartsRestApi;

use Spryker\Glue\Kernel\AbstractBundleConfig;

class CompanyBusinessUnitsCartsRestApiConfig extends AbstractBundleConfig
{
    /**
     * @var string
     */
    public const PARENT_RESOURCE_COMPANY_BUSINESS_UNITS = 'company-business-units';

    /**
     * @var string
     */
    public const RESOURCE_COMPANY_BUSINESS_UNIT_CARTS = 'company-business-unit-carts';

    /**
     * @var string
     */
    public const RESOURCE_CART_ITEMS = 'items';

    /**
     * @var string
     */
    public const RESOURCE_CARTS = 'carts';

    /**
     * @var string
     */
    public const CONTROLLER_COMPANY_BUSINESS_UNITS_CARTS = 'company-business-units-carts-resource';

    /**
     * @var string
     */
    public const RESPONSE_CODE_COMPANY_BUSINESS_UNIT_IDENTIFIER_MISSING = '3000';

    /**
     * @var string
     */
    public const RESPONSE_CODE_CANT_FIND_CART = '3001';

    /**
     * @var string
     */
    public const EXCEPTION_MESSAGE_CANT_FIND_CART = 'Can\'t find cart by the given identifier';

    /**
     * @var string
     */
    public const EXCEPTION_MESSAGE_COMPANY_BUSINESS_UNIT_IDENTIFIER_MISSING = 'Company business unit uuid is missing.';
}
