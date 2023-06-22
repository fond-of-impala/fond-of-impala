<?php

namespace FondOfImpala\Client\ConditionalAvailabilityPageSearch\Plugin\SearchExtension;

use Elastica\ResultSet;
use Generated\Shared\Search\ConditionalAvailabilityPeriodIndexMap;
use Spryker\Client\SearchElasticsearch\Plugin\ResultFormatter\AbstractElasticsearchResultFormatterPlugin;

class RawConditionalAvailabilityPeriodsResultFormatterPlugin extends AbstractElasticsearchResultFormatterPlugin
{
    /**
     * @var string
     */
    public const NAME = 'periods';

    /**
     * @return string
     */
    public function getName()
    {
        return static::NAME;
    }

    /**
     * @param \Elastica\ResultSet $searchResult
     * @param array $requestParameters
     *
     * @return mixed
     */
    public function formatSearchResult(ResultSet $searchResult, array $requestParameters = [])
    {
        $rawConditionalAvailabilityPeriods = [];
        foreach ($searchResult->getResults() as $document) {
            $rawConditionalAvailabilityPeriods[] = $document->getSource()[ConditionalAvailabilityPeriodIndexMap::SEARCH_RESULT_DATA];
        }

        return $rawConditionalAvailabilityPeriods;
    }
}
