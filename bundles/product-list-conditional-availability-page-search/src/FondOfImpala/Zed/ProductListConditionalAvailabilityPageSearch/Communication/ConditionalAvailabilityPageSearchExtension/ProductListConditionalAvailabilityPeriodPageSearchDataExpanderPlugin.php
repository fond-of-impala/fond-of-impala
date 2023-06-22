<?php

namespace FondOfImpala\Zed\ProductListConditionalAvailabilityPageSearch\Communication\ConditionalAvailabilityPageSearchExtension;

use FondOfImpala\Zed\ConditionalAvailabilityPageSearchExtension\Dependency\Plugin\ConditionalAvailabilityPeriodPageSearchDataExpanderPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

class ProductListConditionalAvailabilityPeriodPageSearchDataExpanderPlugin extends AbstractPlugin implements ConditionalAvailabilityPeriodPageSearchDataExpanderPluginInterface
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
     * Specification:
     * - Expands the mapped search data.
     *
     * @api
     *
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
