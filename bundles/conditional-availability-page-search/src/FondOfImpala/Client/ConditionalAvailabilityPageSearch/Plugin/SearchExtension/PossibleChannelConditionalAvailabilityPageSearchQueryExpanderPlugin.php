<?php

namespace FondOfImpala\Client\ConditionalAvailabilityPageSearch\Plugin\SearchExtension;

use Elastica\Query;
use Elastica\Query\BoolQuery;
use Elastica\Query\Term;
use FondOfImpala\Shared\ConditionalAvailabilityPageSearch\ConditionalAvailabilityPageSearchConstants;
use Generated\Shared\Search\ConditionalAvailabilityPeriodIndexMap;
use Generated\Shared\Transfer\CustomerTransfer;
use InvalidArgumentException;
use Spryker\Client\Kernel\AbstractPlugin;
use Spryker\Client\SearchExtension\Dependency\Plugin\QueryExpanderPluginInterface;
use Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface;

/**
 * @method \FondOfImpala\Client\ConditionalAvailabilityPageSearch\ConditionalAvailabilityPageSearchFactory getFactory()
 */
class PossibleChannelConditionalAvailabilityPageSearchQueryExpanderPlugin extends AbstractPlugin implements QueryExpanderPluginInterface
{
    /**
     * @param \Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface $searchQuery
     * @param array<string, mixed> $requestParameters
     *
     * @return \Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface
     */
    public function expandQuery(QueryInterface $searchQuery, array $requestParameters = [])
    {
        if (!isset($requestParameters[ConditionalAvailabilityPageSearchConstants::PARAMETER_CHANNEL])) {
            return $searchQuery;
        }

        $customerTransfer = $this->getCustomer();
        $channel = $requestParameters[ConditionalAvailabilityPageSearchConstants::PARAMETER_CHANNEL];

        if ($customerTransfer === null || !in_array($channel, $customerTransfer->getPossibleAvailabilityChannels(), true)) {
            $channel = '';
        }

        $term = (new Term())->setTerm(
            ConditionalAvailabilityPeriodIndexMap::CHANNEL,
            $channel,
        );

        $this->getBoolQuery($searchQuery->getSearchQuery())
            ->addMust($term);

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
