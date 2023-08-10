<?php

namespace FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Communication\Plugin\PriceProductPriceListPageSearchExtension;

use FondOfImpala\Zed\PriceProductPriceListPageSearchExtension\Dependency\Plugin\PriceProductAbstractPriceListPageSearchDataExpanderPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Business\ProductListPriceProductPriceListPageSearchFacadeInterface getFacade()
 * @method \FondOfImpala\Zed\ProductListPriceProductPriceListPageSearch\Communication\ProductListPriceProductPriceListPageSearchCommunicationFactory getFactory()
 */
class ProductListPriceProductAbstractPriceListPageSearchDataExpanderPlugin extends AbstractPlugin implements PriceProductAbstractPriceListPageSearchDataExpanderPluginInterface
{
    /**
     * @var string
     */
    protected const DATA_KEY_PRODUCT_LIST_MAP = 'product_list_map';

    /**
     * @var string
     */
    protected const SEARCH_DATA_KEY_PRODUCT_LISTS = 'product-lists';

    /**
     * @param array $data
     * @param array $searchData
     *
     * @return array
     */
    public function expand(array $data, array $searchData): array
    {
        if (!isset($data[static::DATA_KEY_PRODUCT_LIST_MAP])) {
            return $searchData;
        }

        $searchData[static::SEARCH_DATA_KEY_PRODUCT_LISTS] = $data[static::DATA_KEY_PRODUCT_LIST_MAP];

        return $searchData;
    }
}
