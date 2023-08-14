<?php

namespace FondOfImpala\Glue\PriceProductPriceListSearchRestApi;

use Spryker\Glue\Kernel\AbstractBundleConfig;

class PriceProductPriceListSearchRestApiConfig extends AbstractBundleConfig
{
    /**
     * @var string
     */
    public const RESOURCE_PRICE_PRODUCT_CONCRETE_PRICE_LIST_SEARCH = 'price-product-concrete-price-list-search';

    /**
     * @var string
     */
    public const RESOURCE_PRICE_PRODUCT_ABSTRACT_PRICE_LIST_SEARCH = 'price-product-abstract-price-list-search';

    /**
     * @var string
     */
    public const CONTROLLER_PRICE_PRODUCT_CONCRETE_PRICE_LIST_SEARCH = 'price-product-concrete-price-list-search-resource';

    /**
     * @var string
     */
    public const CONTROLLER_PRICE_PRODUCT_ABSTRACT_PRICE_LIST_SEARCH = 'price-product-abstract-price-list-search-resource';

    /**
     * @var string
     */
    public const QUERY_STRING_PARAMETER = 'q';
}
