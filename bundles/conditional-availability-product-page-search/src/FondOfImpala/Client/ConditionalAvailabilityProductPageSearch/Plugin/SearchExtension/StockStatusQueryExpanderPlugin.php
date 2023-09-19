<?php

namespace FondOfImpala\Client\ConditionalAvailabilityProductPageSearch\Plugin\SearchExtension;

use Elastica\Query;
use Elastica\Query\BoolQuery;
use FondOfImpala\Shared\ConditionalAvailabilityProductPageSearch\ConditionalAvailabilityProductPageSearchConstants;
use Generated\Shared\Search\PageIndexMap;
use InvalidArgumentException;
use Spryker\Client\Kernel\AbstractPlugin;
use Spryker\Client\SearchExtension\Dependency\Plugin\QueryExpanderPluginInterface;
use Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface;

/**
 * @method \FondOfImpala\Client\ConditionalAvailabilityProductPageSearch\ConditionalAvailabilityProductPageSearchFactory getFactory()
 */
class StockStatusQueryExpanderPlugin extends AbstractPlugin implements QueryExpanderPluginInterface
{
    /**
     * @param \Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface $searchQuery
     * @param array<string, mixed> $requestParameters
     *
     * @return \Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface
     */
    public function expandQuery(QueryInterface $searchQuery, array $requestParameters = [])
    {
        if (!isset($requestParameters[ConditionalAvailabilityProductPageSearchConstants::PARAMETER_STOCK_STATUS])) {
            return $searchQuery;
        }

        $stockStatus = $requestParameters[ConditionalAvailabilityProductPageSearchConstants::PARAMETER_STOCK_STATUS];

        if (!is_string($stockStatus) || $stockStatus === '') {
            return $searchQuery;
        }

        $this->addStockStatusFilterToQuery($searchQuery->getSearchQuery(), $stockStatus);

        return $searchQuery;
    }

    /**
     * @param \Elastica\Query $query
     * @param string $stockStatus
     *
     * @return void
     */
    protected function addStockStatusFilterToQuery(Query $query, string $stockStatus): void
    {
        $boolQuery = $this->getBoolQuery($query);

        /** @var \Elastica\Query\MatchQuery $matchQuery */
        $matchQuery = $this->getFactory()->createQueryBuilder()->createMatchQuery();
        $matchQuery->setField(PageIndexMap::STOCK_STATUS, $stockStatus);

        $boolQuery->addMust($matchQuery);
    }

    /**
     * @param \Elastica\Query $query
     *
     * @throws \InvalidArgumentException
     *
     * @return \Elastica\Query\BoolQuery
     */
    protected function getBoolQuery(Query $query): BoolQuery
    {
        $boolQuery = $query->getQuery();

        if (!$boolQuery instanceof BoolQuery) {
            throw new InvalidArgumentException(sprintf(
                'Stock Status query expander available only with %s, got: %s',
                BoolQuery::class,
                get_class($boolQuery),
            ));
        }

        return $boolQuery;
    }
}
