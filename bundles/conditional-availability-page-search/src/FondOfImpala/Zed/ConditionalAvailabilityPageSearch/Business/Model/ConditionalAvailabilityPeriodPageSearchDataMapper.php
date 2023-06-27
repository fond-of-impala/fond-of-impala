<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\Model;

use FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Dependency\Facade\ConditionalAvailabilityPageSearchToStoreFacadeInterface;
use Generated\Shared\Search\ConditionalAvailabilityPeriodIndexMap;

class ConditionalAvailabilityPeriodPageSearchDataMapper implements ConditionalAvailabilityPeriodPageSearchDataMapperInterface
{
    /**
     * @var string
     */
    protected const DATA_KEY_SKU = 'sku';

    /**
     * @var string
     */
    protected const DATA_KEY_QUANTITY = 'quantity';

    /**
     * @var string
     */
    protected const DATA_KEY_WAREHOUSE_GROUP = 'warehouse_group';

    /**
     * @var string
     */
    protected const DATA_KEY_ORIGINAL_START_AT = 'original_start_at';

    /**
     * @var string
     */
    protected const DATA_KEY_START_AT = 'start_at';

    /**
     * @var string
     */
    protected const DATA_KEY_END_AT = 'end_at';

    /**
     * @var string
     */
    protected const DATA_KEY_STORE = 'store';

    /**
     * @var string
     */
    protected const SEARCH_RESULT_DATA_KEY_SKU = 'sku';

    /**
     * @var string
     */
    protected const SEARCH_RESULT_DATA_KEY_QUANTITY = 'quantity';

    /**
     * @var string
     */
    protected const SEARCH_RESULT_DATA_KEY_WAREHOUSE_GROUP = 'warehouse_group';

    /**
     * @var string
     */
    protected const SEARCH_RESULT_DATA_KEY_ORIGINAL_START_AT = 'original_start_at';

    /**
     * @var string
     */
    protected const SEARCH_RESULT_DATA_KEY_START_AT = 'start_at';

    /**
     * @var string
     */
    protected const SEARCH_RESULT_DATA_KEY_END_AT = 'end_at';

    protected ConditionalAvailabilityPageSearchToStoreFacadeInterface $storeFacade;

    /**
     * @var array<\FondOfImpala\Zed\ConditionalAvailabilityPageSearchExtension\Dependency\Plugin\ConditionalAvailabilityPeriodPageSearchDataExpanderPluginInterface>
     */
    protected array $conditionalAvailabilityPeriodPageSearchDataExpanderPlugins;

    /**
     * @param \FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Dependency\Facade\ConditionalAvailabilityPageSearchToStoreFacadeInterface $storeFacade
     * @param array<\FondOfImpala\Zed\ConditionalAvailabilityPageSearchExtension\Dependency\Plugin\ConditionalAvailabilityPeriodPageSearchDataExpanderPluginInterface> $conditionalAvailabilityPeriodPageSearchDataExpanderPlugins
     */
    public function __construct(
        ConditionalAvailabilityPageSearchToStoreFacadeInterface $storeFacade,
        array $conditionalAvailabilityPeriodPageSearchDataExpanderPlugins
    ) {
        $this->storeFacade = $storeFacade;
        $this->conditionalAvailabilityPeriodPageSearchDataExpanderPlugins = $conditionalAvailabilityPeriodPageSearchDataExpanderPlugins;
    }

    /**
     * @param array $data
     *
     * @return array
     */
    public function mapConditionalAvailabilityPeriodDataToSearchData(
        array $data
    ): array {
        $store = $this->storeFacade->getCurrentStore()->getName();

        if (isset($data[static::DATA_KEY_STORE])) {
            $store = $data[static::DATA_KEY_STORE];
        }

        $searchData = [
            ConditionalAvailabilityPeriodIndexMap::STORE => $store,
            ConditionalAvailabilityPeriodIndexMap::LOCALE => null,
            ConditionalAvailabilityPeriodIndexMap::SKU => $data[static::DATA_KEY_SKU],
            ConditionalAvailabilityPeriodIndexMap::QUANTITY => $data[static::DATA_KEY_QUANTITY],
            ConditionalAvailabilityPeriodIndexMap::WAREHOUSE_GROUP => $data[static::DATA_KEY_WAREHOUSE_GROUP],
            ConditionalAvailabilityPeriodIndexMap::ORIGINAL_START_AT => $data[static::DATA_KEY_ORIGINAL_START_AT],
            ConditionalAvailabilityPeriodIndexMap::START_AT => $data[static::DATA_KEY_START_AT],
            ConditionalAvailabilityPeriodIndexMap::END_AT => $data[static::DATA_KEY_END_AT],
            ConditionalAvailabilityPeriodIndexMap::SEARCH_RESULT_DATA => $this->mapConditionalAvailabilityPeriodDataToSearchResultData($data),
        ];

        return $this->expandSearchData($data, $searchData);
    }

    /**
     * @param array $data
     *
     * @return array
     */
    protected function mapConditionalAvailabilityPeriodDataToSearchResultData(array $data): array
    {
        return [
            static::SEARCH_RESULT_DATA_KEY_SKU => $data[static::DATA_KEY_SKU],
            static::SEARCH_RESULT_DATA_KEY_QUANTITY => $data[static::DATA_KEY_QUANTITY],
            static::SEARCH_RESULT_DATA_KEY_WAREHOUSE_GROUP => $data[static::DATA_KEY_WAREHOUSE_GROUP],
            static::SEARCH_RESULT_DATA_KEY_ORIGINAL_START_AT => $data[static::DATA_KEY_ORIGINAL_START_AT],
            static::SEARCH_RESULT_DATA_KEY_START_AT => $data[static::DATA_KEY_START_AT],
            static::SEARCH_RESULT_DATA_KEY_END_AT => $data[static::DATA_KEY_END_AT],
        ];
    }

    /**
     * @param array $data
     * @param array $searchData
     *
     * @return array
     */
    protected function expandSearchData(array $data, array $searchData): array
    {
        foreach ($this->conditionalAvailabilityPeriodPageSearchDataExpanderPlugins as $conditionalAvailabilityPeriodPageSearchDataExpanderPlugin) {
            $searchData = $conditionalAvailabilityPeriodPageSearchDataExpanderPlugin->expand($data, $searchData);
        }

        return $searchData;
    }
}
