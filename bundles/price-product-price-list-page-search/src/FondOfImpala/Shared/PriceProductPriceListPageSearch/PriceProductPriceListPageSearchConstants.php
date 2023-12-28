<?php

namespace FondOfImpala\Shared\PriceProductPriceListPageSearch;

interface PriceProductPriceListPageSearchConstants
{
    /**
     * @var string
     */
    public const PRICE_PRODUCT_ABSTRACT_PRICE_LIST_RESOURCE_NAME = 'price_product_abstract_price_list';

    /**
     * @var string
     */
    public const PRICE_PRODUCT_CONCRETE_PRICE_LIST_RESOURCE_NAME = 'price_product_concrete_price_list';

    /**
     * @var string
     */
    public const PRICE_PRODUCT_PRICE_LIST_SYNC_SEARCH_QUEUE = 'sync.search.price_product_price_list';

    /**
     * @var string
     */
    public const PRICE_PRODUCT_PRICE_LIST_SYNC_SEARCH_ERROR_QUEUE = 'sync.search.price_product_price_list.error';

    /**
     * @var string
     */
    public const PUBLISH_PRICE_PRODUCT_ABSTRACT_PRICE_LIST = 'publish.price_product_abstract_price_list';

    /**
     * @var string
     */
    public const PUBLISH_PRICE_PRODUCT_CONCRETE_PRICE_LIST = 'publish.price_product_concrete_price_list';

    /**
     * @var string
     */
    public const PARAMETER_SKU = 'sku';

    /**
     * @var string
     */
    public const PARAMETER_NAME = 'name';
}
