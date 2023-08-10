<?php

namespace FondOfImpala\Client\PriceProductPriceListPageSearch;

use Spryker\Client\Kernel\AbstractClient;

/**
 * @method \FondOfImpala\Client\PriceProductPriceListPageSearch\PriceProductPriceListPageSearchFactory getFactory()
 */
class PriceProductPriceListPageSearchClient extends AbstractClient implements PriceProductPriceListPageSearchClientInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param string $searchString
     * @param array $requestParameters
     *
     * @return array
     */
    public function searchAbstract(string $searchString, array $requestParameters): array
    {
        $queryExpanderPlugins = $this->getFactory()->getPriceProductAbstractPriceListSearchQueryExpanderPlugins();

        $searchQuery = $this->getFactory()
            ->createPriceProductAbstractPriceListSearchQuery($searchString, $requestParameters, $queryExpanderPlugins);

        $resultFormatters = $this
            ->getFactory()
            ->getPriceProductAbstractPriceListSearchResultFormatters();

        return $this
            ->getFactory()
            ->getSearchClient()
            ->search($searchQuery, $resultFormatters, $requestParameters);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param string $searchString
     * @param array $requestParameters
     *
     * @return int
     */
    public function searchAbstractCount(string $searchString, array $requestParameters): int
    {
        $queryExpanderPlugins = $this->getFactory()->getPriceProductAbstractPriceListSearchCountQueryExpanderPlugins();

        $searchQuery = $this->getFactory()
            ->createPriceProductAbstractPriceListSearchQuery($searchString, $requestParameters, $queryExpanderPlugins);

        return $this
            ->getFactory()
            ->getSearchClient()
            ->search($searchQuery, [], $requestParameters)
            ->getTotalHits();
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param string $searchString
     * @param array $requestParameters
     *
     * @return array
     */
    public function searchConcrete(string $searchString, array $requestParameters): array
    {
        $queryExpanderPlugins = $this->getFactory()->getPriceProductAbstractPriceListSearchQueryExpanderPlugins();

        $searchQuery = $this->getFactory()
            ->createPriceProductConcretePriceListSearchQuery($searchString, $requestParameters, $queryExpanderPlugins);

        $resultFormatters = $this
            ->getFactory()
            ->getPriceProductAbstractPriceListSearchResultFormatters();

        return $this
            ->getFactory()
            ->getSearchClient()
            ->search($searchQuery, $resultFormatters, $requestParameters);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param string $searchString
     * @param array $requestParameters
     *
     * @return int
     */
    public function searchConcreteCount(string $searchString, array $requestParameters): int
    {
        $queryExpanderPlugins = $this->getFactory()->getPriceProductConcretePriceListSearchCountQueryExpanderPlugins();

        $searchQuery = $this->getFactory()
            ->createPriceProductConcretePriceListSearchQuery($searchString, $requestParameters, $queryExpanderPlugins);

        return $this
            ->getFactory()
            ->getSearchClient()
            ->search($searchQuery, [], $requestParameters)
            ->getTotalHits();
    }
}
