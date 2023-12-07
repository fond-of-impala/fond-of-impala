<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityPageSearch\Business\Model;

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
    protected const DATA_KEY_CHANNEL = 'channel';

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
    protected const SEARCH_RESULT_DATA_KEY_CHANNEL = 'channel';

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

    /**
     * @var array<\FondOfImpala\Zed\ConditionalAvailabilityPageSearchExtension\Dependency\Plugin\ConditionalAvailabilityPeriodPageSearchDataExpanderPluginInterface>
     */
    protected array $conditionalAvailabilityPeriodPageSearchDataExpanderPlugins;

    /**
     * @param array<\FondOfImpala\Zed\ConditionalAvailabilityPageSearchExtension\Dependency\Plugin\ConditionalAvailabilityPeriodPageSearchDataExpanderPluginInterface> $conditionalAvailabilityPeriodPageSearchDataExpanderPlugins
     */
    public function __construct(
        array $conditionalAvailabilityPeriodPageSearchDataExpanderPlugins
    ) {
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
        $searchData = [
            ConditionalAvailabilityPeriodIndexMap::SKU => $data[static::DATA_KEY_SKU],
            ConditionalAvailabilityPeriodIndexMap::QUANTITY => $data[static::DATA_KEY_QUANTITY],
            ConditionalAvailabilityPeriodIndexMap::WAREHOUSE_GROUP => $data[static::DATA_KEY_WAREHOUSE_GROUP],
            ConditionalAvailabilityPeriodIndexMap::CHANNEL => $data[static::DATA_KEY_CHANNEL],
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
            static::SEARCH_RESULT_DATA_KEY_CHANNEL => $data[static::DATA_KEY_CHANNEL],
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
