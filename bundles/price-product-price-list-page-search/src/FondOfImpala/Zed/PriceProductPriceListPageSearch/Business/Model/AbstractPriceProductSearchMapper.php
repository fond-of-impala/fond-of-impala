<?php

namespace FondOfImpala\Zed\PriceProductPriceListPageSearch\Business\Model;

use FondOfImpala\Zed\PriceProductPriceListPageSearch\Dependency\Facade\PriceProductPriceListPageSearchToStoreFacadeInterface;
use Generated\Shared\Search\PriceProductPriceListIndexMap;

abstract class AbstractPriceProductSearchMapper implements PriceProductSearchMapperInterface
{
    /**
     * @var string
     */
    protected const DATA_KEY_STORE = 'store';

    /**
     * @var string
     */
    protected const DATA_KEY_ID_PRICE_LIST = 'id_price_list';

    /**
     * @var string
     */
    protected const DATA_KEY_SKU = 'sku';

    /**
     * @var string
     */
    protected const DATA_KEY_PRICE_LIST_NAME = 'price_list_name';

    /**
     * @var string
     */
    protected const DATA_KEY_PRICES = 'prices';

    /**
     * @var string
     */
    protected const SEARCH_RESULT_DATA_KEY_SKU = 'sku';

    /**
     * @var string
     */
    protected const SEARCH_RESULT_DATA_KEY_PRICE_LIST_NAME = 'price_list_name';

    /**
     * @var string
     */
    protected const SEARCH_RESULT_DATA_KEY_ID_PRICE_LIST = 'id_price_list';

    /**
     * @var string
     */
    protected const SEARCH_RESULT_DATA_KEY_PRICES = 'prices';

    protected PriceProductPriceListPageSearchToStoreFacadeInterface $storeFacade;

    /**
     * @param \FondOfImpala\Zed\PriceProductPriceListPageSearch\Dependency\Facade\PriceProductPriceListPageSearchToStoreFacadeInterface $storeFacade
     */
    public function __construct(PriceProductPriceListPageSearchToStoreFacadeInterface $storeFacade)
    {
        $this->storeFacade = $storeFacade;
    }

    /**
     * @param array $data
     *
     * @return array
     */
    public function mapDataToSearchData(array $data): array
    {
        $store = $this->storeFacade->getCurrentStore()->getName();

        if (isset($data[static::DATA_KEY_STORE])) {
            $store = $data[static::DATA_KEY_STORE];
        }

        $searchData = [
            PriceProductPriceListIndexMap::STORE => $store,
            PriceProductPriceListIndexMap::ID_PRICE_LIST => $data[static::DATA_KEY_ID_PRICE_LIST],
            PriceProductPriceListIndexMap::SKU => $data[static::DATA_KEY_SKU],
            PriceProductPriceListIndexMap::PRICE_LIST_NAME => $data[static::DATA_KEY_PRICE_LIST_NAME],
            PriceProductPriceListIndexMap::SEARCH_RESULT_DATA => $this->mapDataToSearchResultData($data),
        ];

        return $this->expandSearchData($data, $searchData);
    }

    /**
     * @param array $data
     *
     * @return array
     */
    protected function mapDataToSearchResultData(array $data): array
    {
        return [
            static::SEARCH_RESULT_DATA_KEY_SKU => $data[static::DATA_KEY_SKU],
            static::SEARCH_RESULT_DATA_KEY_PRICE_LIST_NAME => $data[static::DATA_KEY_PRICE_LIST_NAME],
            static::SEARCH_RESULT_DATA_KEY_ID_PRICE_LIST => $data[static::DATA_KEY_ID_PRICE_LIST],
            static::SEARCH_RESULT_DATA_KEY_PRICES => $data[static::DATA_KEY_PRICES],
        ];
    }

    /**
     * @param array $data
     * @param array $searchData
     *
     * @return array
     */
    abstract protected function expandSearchData(array $data, array $searchData): array;
}
