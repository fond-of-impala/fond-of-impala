<?php

namespace FondOfImpala\Client\ConditionalAvailabilityPageSearch\Dependency\Client;

use Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface;

interface ConditionalAvailabilityPageSearchToSearchClientInterface
{
    /**
     * @param \Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface $searchQuery
     * @param array<\Spryker\Client\SearchExtension\Dependency\Plugin\ResultFormatterPluginInterface> $resultFormatters
     * @param array $requestParameters
     *
     * @return mixed
     */
    public function search(
        QueryInterface $searchQuery,
        array $resultFormatters = [],
        array $requestParameters = []
    );

    /**
     * @param \Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface $searchQuery
     * @param array<\Spryker\Client\SearchExtension\Dependency\Plugin\QueryExpanderPluginInterface> $searchQueryExpanders
     * @param array $requestParameters
     *
     * @return \Spryker\Client\SearchExtension\Dependency\Plugin\QueryInterface
     */
    public function expandQuery(
        QueryInterface $searchQuery,
        array $searchQueryExpanders,
        array $requestParameters = []
    ): QueryInterface;
}
