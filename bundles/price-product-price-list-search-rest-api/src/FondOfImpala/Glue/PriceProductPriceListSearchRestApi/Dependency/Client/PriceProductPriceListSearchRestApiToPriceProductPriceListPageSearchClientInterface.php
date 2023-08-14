<?php

namespace FondOfImpala\Glue\PriceProductPriceListSearchRestApi\Dependency\Client;

interface PriceProductPriceListSearchRestApiToPriceProductPriceListPageSearchClientInterface
{
    /**
     * @param string $searchString
     * @param array $requestParameters
     *
     * @return array
     */
    public function searchAbstract(string $searchString, array $requestParameters): array;

    /**
     * @param string $searchString
     * @param array $requestParameters
     *
     * @return array
     */
    public function searchConcrete(string $searchString, array $requestParameters): array;
}
