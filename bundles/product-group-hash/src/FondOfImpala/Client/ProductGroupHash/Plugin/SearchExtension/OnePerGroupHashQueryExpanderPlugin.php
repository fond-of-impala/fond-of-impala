<?php

namespace FondOfImpala\Client\ProductGroupHash\Plugin\SearchExtension;

use Elastica\Aggregation\Cardinality;
use Elastica\Collapse;
use Elastica\Collapse\InnerHits;
use Elastica\Query;
use FondOfImpala\Shared\ProductGroupHash\ProductGroupHashConstants;
use Generated\Shared\Search\PageIndexMap;
use InvalidArgumentException;
use Spryker\Client\SearchExtension\Dependency\Plugin\QueryExpanderPluginInterface;
use Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

class OnePerGroupHashQueryExpanderPlugin extends AbstractPlugin implements QueryExpanderPluginInterface
{
    /**
     * @var string
     */
    public const AGGREGATION_NAME_TOTAL_COLLAPSED_HITS = 'total_collapsed_hits';

    /**
     * @param \Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface $searchQuery
     * @param array<string, mixed> $requestParameters
     *
     * @throws \InvalidArgumentException
     *
     * @return \Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface
     */
    public function expandQuery(QueryInterface $searchQuery, array $requestParameters = [])
    {
        if (!$this->canExpandQuery($requestParameters)) {
            return $searchQuery;
        }

        $query = $searchQuery->getSearchQuery();

        if (!($query instanceof Query)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Query expander available only with %s, got: %s',
                    Query::class,
                    $query::class,
                ),
            );
        }

        $query->setCollapse(
            (new Collapse())->setFieldname(PageIndexMap::GROUP_HASH)
                ->setInnerHits((new InnerHits())->setName(ProductGroupHashConstants::INNER_HITS_NAME)),
        );

        $query->addAggregation(
            (new Cardinality(static::AGGREGATION_NAME_TOTAL_COLLAPSED_HITS))
                ->setField(PageIndexMap::GROUP_HASH),
        );

        return $searchQuery;
    }

    /**
     * @param array $requestParameters
     *
     * @return bool
     */
    protected function canExpandQuery(array $requestParameters = []): bool
    {
        return isset($requestParameters[ProductGroupHashConstants::PARAMETER_ONE_PER_GROUP_HASH])
            && preg_match('/^(true|false)$/', $requestParameters[ProductGroupHashConstants::PARAMETER_ONE_PER_GROUP_HASH])
            && ((bool)$requestParameters[ProductGroupHashConstants::PARAMETER_ONE_PER_GROUP_HASH]) === true;
    }
}
