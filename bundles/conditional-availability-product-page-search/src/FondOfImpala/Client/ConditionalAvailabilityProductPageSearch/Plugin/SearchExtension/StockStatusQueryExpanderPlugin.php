<?php

namespace FondOfImpala\Client\ConditionalAvailabilityProductPageSearch\Plugin\SearchExtension;

use Elastica\Aggregation\Terms as AggregationTerms;
use Elastica\Query;
use Elastica\Query\BoolQuery;
use Elastica\Query\Terms as QueryTerms;
use FondOfImpala\Shared\ConditionalAvailabilityProductPageSearch\ConditionalAvailabilityProductPageSearchConstants;
use Generated\Shared\Search\PageIndexMap;
use Generated\Shared\Transfer\CustomerTransfer;
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
     * @var string
     */
    protected const TERM_NAME = 'stock-status';

    /**
     * @var string
     */
    protected const TERM_FIELD = 'stock-status';

    /**
     * @var int
     */
    protected const SIZE = 9999;

    /**
     * @param \Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface $searchQuery
     * @param array<string, mixed> $requestParameters
     *
     * @return \Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface
     */
    public function expandQuery(QueryInterface $searchQuery, array $requestParameters = [])
    {
        /** @var \Elastica\Query $query */
        $query = $searchQuery->getSearchQuery();

        $query->addAggregation(
            (new AggregationTerms(static::TERM_NAME))
                ->setSize(static::SIZE)
                ->setField(static::TERM_FIELD),
        );

        $this->addStockStatusFilterToQuery($query, $requestParameters);

        return $searchQuery;
    }

    /**
     * @param \Elastica\Query $query
     * @param array<mixed> $requestParameters
     *
     * @return void
     */
    protected function addStockStatusFilterToQuery(Query $query, array $requestParameters = []): void
    {
        if (!isset($requestParameters[ConditionalAvailabilityProductPageSearchConstants::PARAMETER_STOCK_STATUS])) {
            return;
        }

        $stockStatus = $requestParameters[ConditionalAvailabilityProductPageSearchConstants::PARAMETER_STOCK_STATUS];

        if (!is_string($stockStatus) || $stockStatus === '') {
            return;
        }

        $customerTransfer = $this->getCustomer();

        if (!$customerTransfer || !$customerTransfer->getAvailabilityChannel()) {
            return;
        }

        $stockStatus = $customerTransfer->getAvailabilityChannel() . '-' . $stockStatus;

        $this->getBoolQuery($query)
            ->addMust(new QueryTerms(PageIndexMap::STOCK_STATUS, [$stockStatus]));
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

    /**
     * @return \Generated\Shared\Transfer\CustomerTransfer|null
     */
    protected function getCustomer(): ?CustomerTransfer
    {
        return $this->getFactory()
            ->getCustomerClient()
            ->getCustomer();
    }
}
