<?php

namespace FondOfImpala\Glue\PriceProductPriceListSearchRestApi\Dependency\Client;

use FondOfImpala\Client\PriceProductPriceListPageSearch\PriceProductPriceListPageSearchClientInterface;

class PriceProductPriceListSearchRestApiToPriceProductPriceListPageSearchClientBridge implements PriceProductPriceListSearchRestApiToPriceProductPriceListPageSearchClientInterface
{
    protected PriceProductPriceListPageSearchClientInterface $priceProductPriceListPageSearchClient;

    /**
     * @param \FondOfImpala\Client\PriceProductPriceListPageSearch\PriceProductPriceListPageSearchClientInterface $priceProductPriceListPageSearchClient
     */
    public function __construct(PriceProductPriceListPageSearchClientInterface $priceProductPriceListPageSearchClient)
    {
        $this->priceProductPriceListPageSearchClient = $priceProductPriceListPageSearchClient;
    }

    /**
     * @param string $searchString
     * @param array $requestParameters
     *
     * @return array
     */
    public function searchAbstract(string $searchString, array $requestParameters): array
    {
        return $this->priceProductPriceListPageSearchClient->searchAbstract($searchString, $requestParameters);
    }

    /**
     * @param string $searchString
     * @param array $requestParameters
     *
     * @return array
     */
    public function searchConcrete(string $searchString, array $requestParameters): array
    {
        return $this->priceProductPriceListPageSearchClient->searchConcrete($searchString, $requestParameters);
    }
}
