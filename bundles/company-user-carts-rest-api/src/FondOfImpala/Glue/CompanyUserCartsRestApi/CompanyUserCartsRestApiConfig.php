<?php

namespace FondOfImpala\Glue\CompanyUserCartsRestApi;

use Spryker\Glue\Kernel\AbstractBundleConfig;

class CompanyUserCartsRestApiConfig extends AbstractBundleConfig
{
    /**
     * @var string
     */
    public const RESOURCE_COMPANY_USER_CARTS = 'company-user-carts';

    /**
     * @var string
     */
    public const RESOURCE_COMPANY_USERS = 'company-users';

    /**
     * @var string
     */
    public const CONTROLLER_CARTS = 'carts-resource';

    /**
     * @var string
     */
    public const RESPONSE_DETAIL_CART_ID_IS_MISSING = 'Cart id is missing.';

    /**
     * @var string
     */
    public const RESPONSE_CODE_OTHER = '1001';

    /**
     * @var string
     */
    public const RESPONSE_CODE_CART_ID_IS_MISSING = '1002';

    /**
     * @var string
     */
    public const FORMAT_SELF_LINK_CART_RESOURCE = '%s/%s/%s/%s';

    /**
     * @var string
     */
    public const RESOURCE_CARTS = 'carts';

    /**
     * @var string
     */
    public const RESOURCE_CART_ITEMS = 'items';
}
