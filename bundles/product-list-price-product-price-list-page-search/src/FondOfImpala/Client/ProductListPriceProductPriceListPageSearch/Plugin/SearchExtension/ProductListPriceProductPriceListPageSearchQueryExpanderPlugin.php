<?php

namespace FondOfImpala\Client\ProductListPriceProductPriceListPageSearch\Plugin\SearchExtension;

use Elastica\Query;
use Elastica\Query\BoolQuery;
use Elastica\Query\Terms;
use Generated\Shared\Search\PriceProductPriceListIndexMap;
use Generated\Shared\Transfer\CustomerProductListCollectionTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use InvalidArgumentException;
use Spryker\Client\Kernel\AbstractPlugin;
use Spryker\Client\SearchExtension\Dependency\Plugin\QueryExpanderPluginInterface;
use Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface;

/**
 * @method \FondOfImpala\Client\ProductListPriceProductPriceListPageSearch\ProductListPriceProductPriceListPageSearchFactory getFactory()
 */
class ProductListPriceProductPriceListPageSearchQueryExpanderPlugin extends AbstractPlugin implements QueryExpanderPluginInterface
{
    /**
     * @param \Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface $searchQuery
     * @param array $requestParameters
     *
     * @return \Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface
     */
    public function expandQuery(QueryInterface $searchQuery, array $requestParameters = []): QueryInterface
    {
        $query = $searchQuery->getSearchQuery();

        $this->expandQueryWithBlacklistFilter($query);
        $this->expandQueryWithWhitelistFilter($query);

        return $searchQuery;
    }

    /**
     * @param \Elastica\Query $query
     *
     * @return void
     */
    protected function expandQueryWithBlacklistFilter(Query $query): void
    {
        $blacklistIds = $this->getBlacklistIds();

        if (!count($blacklistIds)) {
            return;
        }

        $this->getBoolQuery($query)->addMustNot($this->createBlacklistTermQuery($blacklistIds));
    }

    /**
     * @param \Elastica\Query $query
     *
     * @return void
     */
    protected function expandQueryWithWhitelistFilter(Query $query): void
    {
        $whitelistIds = $this->getWhitelistIds();

        if (!count($whitelistIds)) {
            return;
        }

        $this->getBoolQuery($query)->addFilter($this->createWhitelistTermQuery($whitelistIds));
    }

    /**
     * @param array $blacklistIds
     *
     * @return \Elastica\Query\Terms
     */
    protected function createBlacklistTermQuery(array $blacklistIds): Terms
    {
        return new Terms(PriceProductPriceListIndexMap::PRODUCT_LISTS_BLACKLISTS, $blacklistIds);
    }

    /**
     * @param array $whitelistIds
     *
     * @return \Elastica\Query\Terms
     */
    protected function createWhitelistTermQuery(array $whitelistIds): Terms
    {
        return new Terms(PriceProductPriceListIndexMap::PRODUCT_LISTS_WHITELISTS, $whitelistIds);
    }

    /**
     * @return int[]
     */
    protected function getBlacklistIds(): array
    {
        $customerProductListCollectionTransfer = $this->findCustomerProductListCollection();

        if (!$customerProductListCollectionTransfer) {
            return [];
        }

        return $customerProductListCollectionTransfer->getBlacklistIds() ?: [];
    }

    /**
     * @return int[]
     */
    protected function getWhitelistIds(): array
    {
        $customerProductListCollectionTransfer = $this->findCustomerProductListCollection();

        if (!$customerProductListCollectionTransfer) {
            return [];
        }

        return $customerProductListCollectionTransfer->getWhitelistIds() ?: [];
    }

    /**
     * @return \Generated\Shared\Transfer\CustomerProductListCollectionTransfer|null
     */
    protected function findCustomerProductListCollection(): ?CustomerProductListCollectionTransfer
    {
        $customer = $this->getCustomer();

        if ($customer === null) {
            return null;
        }

        $customerProductListCollectionTransfer = $customer->getCustomerProductListCollection();

        if ($customerProductListCollectionTransfer === null) {
            return null;
        }

        return $customerProductListCollectionTransfer;
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
                'Product List Query Expander available only with %s, got: %s',
                BoolQuery::class,
                get_class($boolQuery),
            ));
        }

        return $boolQuery;
    }
}
