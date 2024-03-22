<?php

namespace FondOfImpala\Client\ProductGroupHash\Plugin\SearchExtension;

use Elastica\Query;
use Elastica\Query\BoolQuery;
use Elastica\Query\Terms;
use FondOfImpala\Shared\ProductGroupHash\ProductGroupHashConstants;
use Generated\Shared\Search\PageIndexMap;
use InvalidArgumentException;
use Spryker\Client\SearchExtension\Dependency\Plugin\QueryExpanderPluginInterface;
use Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

class GroupHashQueryExpanderPlugin extends AbstractPlugin implements QueryExpanderPluginInterface
{
    /**
     * @param \Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface $searchQuery
     * @param array<string, mixed> $requestParameters
     *
     * @return \Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface
     */
    public function expandQuery(QueryInterface $searchQuery, array $requestParameters = [])
    {
        if (!isset($requestParameters[ProductGroupHashConstants::PARAMETER_GROUP_HASH])) {
            return $searchQuery;
        }

        $groupHashes = $requestParameters[ProductGroupHashConstants::PARAMETER_GROUP_HASH];

        if (!is_array($groupHashes) || count($groupHashes) === 0) {
            return $searchQuery;
        }

        $this->getBoolQuery($searchQuery->getSearchQuery())
            ->addMust(new Terms(PageIndexMap::GROUP_HASH, $groupHashes));

        return $searchQuery;
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

        if (is_array($boolQuery)) {
            throw new InvalidArgumentException(sprintf(
                'Localized query expander available only with %s, got: array',
                BoolQuery::class,
            ));
        }

        if (!$boolQuery instanceof BoolQuery) {
            throw new InvalidArgumentException(sprintf(
                'Localized query expander available only with %s, got: %s',
                BoolQuery::class,
                $boolQuery::class,
            ));
        }

        return $boolQuery;
    }
}
