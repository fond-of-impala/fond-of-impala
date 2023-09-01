<?php

namespace FondOfImpala\Glue\PriceListsRestApi;

use Spryker\Glue\Kernel\AbstractBundleConfig;

class PriceListsRestApiConfig extends AbstractBundleConfig
{
    /**
     * @var string
     */
    public const RESOURCE_PRICE_LISTS = 'price-lists';

    /**
     * @var string
     */
    public const CONTROLLER_PRICE_LISTS = 'price-lists-resource';

    /**
     * @var string
     */
    public const ACTION_PRICE_LISTS_GET = 'get';

    /**
     * @var string
     */
    public const RESPONSE_CODE_UUID_MISSING = '800';

    /**
     * @var string
     */
    public const RESPONSE_DETAILS_UUID_MISSING = 'Uuid is missing.';

    /**
     * @var string
     */
    public const RESPONSE_CODE_PRICE_LIST_NOT_FOUND = '801';

    /**
     * @var string
     */
    public const RESPONSE_DETAILS_PRICE_LIST_NOT_FOUND = 'Price list not found.';

    /**
     * @var string
     */
    public const RESPONSE_CODE_NO_PERMISSION = '802';

    /**
     * @var string
     */
    public const RESPONSE_DETAILS_NO_PERMISSION = 'No permission to read price list.';
}
