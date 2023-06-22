<?php

namespace FondOfImpala\Client\ConditionalAvailabilityPageSearch\Plugin\SearchExtension;

use Elastica\Query;
use Elastica\Query\BoolQuery;
use Elastica\Query\Range;
use FondOfImpala\Shared\ConditionalAvailabilityPageSearch\ConditionalAvailabilityPageSearchConstants;
use Generated\Shared\Search\ConditionalAvailabilityPeriodIndexMap;
use InvalidArgumentException;
use Spryker\Client\Kernel\AbstractPlugin;
use Spryker\Client\SearchExtension\Dependency\Plugin\QueryExpanderPluginInterface;
use Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface;

class MinQtyConditionalAvailabilityPageSearchQueryExpanderPlugin extends AbstractPlugin implements
    QueryExpanderPluginInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface $searchQuery
     * @param array $requestParameters
     *
     * @return \Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface
     */
    public function expandQuery(QueryInterface $searchQuery, array $requestParameters = []): QueryInterface
    {
        if (!$this->canExpandQuery($requestParameters)) {
            return $searchQuery;
        }

        $minQty = (int)$requestParameters[ConditionalAvailabilityPageSearchConstants::PARAMETER_MIN_QTY];

        $range = (new Range())->addField(
            ConditionalAvailabilityPeriodIndexMap::QUANTITY,
            ['gte' => $minQty],
        );

        $this->getBoolQuery($searchQuery->getSearchQuery())
            ->addMust($range);

        return $searchQuery;
    }

    /**
     * @param array $requestParameters
     *
     * @return bool
     */
    protected function canExpandQuery(array $requestParameters = []): bool
    {
        return isset($requestParameters[ConditionalAvailabilityPageSearchConstants::PARAMETER_MIN_QTY])
            && preg_match('/^[-+]?\d*$/', $requestParameters[ConditionalAvailabilityPageSearchConstants::PARAMETER_MIN_QTY]);
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
            throw new InvalidArgumentException(
                sprintf(
                    'Localized query expander available only with %s, got: %s',
                    BoolQuery::class,
                    get_class($boolQuery),
                ),
            );
        }

        return $boolQuery;
    }
}
