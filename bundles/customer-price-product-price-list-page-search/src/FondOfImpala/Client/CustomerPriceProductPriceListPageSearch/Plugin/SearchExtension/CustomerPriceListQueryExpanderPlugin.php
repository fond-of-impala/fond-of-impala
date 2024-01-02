<?php

namespace FondOfImpala\Client\CustomerPriceProductPriceListPageSearch\Plugin\SearchExtension;

use Elastica\Query;
use Elastica\Query\BoolQuery;
use Elastica\Query\Terms;
use Generated\Shared\Search\PriceProductPriceListIndexMap;
use Generated\Shared\Transfer\CustomerTransfer;
use InvalidArgumentException;
use Spryker\Client\Kernel\AbstractPlugin;
use Spryker\Client\SearchExtension\Dependency\Plugin\QueryExpanderPluginInterface;
use Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface;

/**
 * @method \FondOfImpala\Client\CustomerPriceProductPriceListPageSearch\CustomerPriceProductPriceListPageSearchFactory getFactory()
 */
class CustomerPriceListQueryExpanderPlugin extends AbstractPlugin implements QueryExpanderPluginInterface
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
        $query = $searchQuery->getSearchQuery();

        $this->expandQueryWithCustomerPriceListIds($query);

        return $searchQuery;
    }

    /**
     * @param \Elastica\Query $query
     *
     * @return void
     */
    protected function expandQueryWithCustomerPriceListIds(Query $query): void
    {
        $customerPriceListIds = $this->getCustomerPriceListIds();

        if (count($customerPriceListIds) === 0) {
            return;
        }

        $boolQuery = $this->getBoolQuery($query);
        $boolQuery->addFilter(new Terms(PriceProductPriceListIndexMap::ID_PRICE_LIST, $customerPriceListIds));
    }

    /**
     * @return array<int>
     */
    protected function getCustomerPriceListIds(): array
    {
        $customerPriceListIds = [];
        $customerTransfer = $this->getCustomer();

        if ($customerTransfer === null || $customerTransfer->getPriceListCollection() === null) {
            return $customerPriceListIds;
        }

        foreach ($customerTransfer->getPriceListCollection()->getPriceLists() as $priceListTransfer) {
            $customerPriceListIds[] = $priceListTransfer->getIdPriceList();
        }

        return $customerPriceListIds;
    }

    /**
     * @return \Generated\Shared\Transfer\CustomerTransfer|null
     */
    protected function getCustomer(): ?CustomerTransfer
    {
        return $this->getFactory()->getCustomerClient()->getCustomer();
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
                'Price List Query Expander available only with %s, got: %s',
                BoolQuery::class,
                get_class($boolQuery),
            ));
        }

        return $boolQuery;
    }
}
