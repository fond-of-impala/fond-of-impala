<?php

namespace FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\Dependency\Client;

interface ConditionalAvailabilityPageSearchRestApiToConditionalAvailabilityPageSearchClientInterface
{
    /**
     * @param string $searchString
     * @param array $requestParameters
     *
     * @return array
     */
    public function search(string $searchString, array $requestParameters = []): array;
}
