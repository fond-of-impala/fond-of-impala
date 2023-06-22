<?php

namespace FondOfImpala\Glue\ConditionalAvailabilityPageSearchRestApi\Dependency\Client;

use FondOfImpala\Client\ConditionalAvailabilityPageSearch\ConditionalAvailabilityPageSearchClientInterface;

class ConditionalAvailabilityPageSearchRestApiToConditionalAvailabilityPageSearchClientBridge implements ConditionalAvailabilityPageSearchRestApiToConditionalAvailabilityPageSearchClientInterface
{
    /**
     * @var \FondOfImpala\Client\ConditionalAvailabilityPageSearch\ConditionalAvailabilityPageSearchClientInterface
     */
    protected $conditionalAvailabilityPageSearchClient;

    /**
     * @param \FondOfImpala\Client\ConditionalAvailabilityPageSearch\ConditionalAvailabilityPageSearchClientInterface $conditionalAvailabilityPageSearchClient
     */
    public function __construct(
        ConditionalAvailabilityPageSearchClientInterface $conditionalAvailabilityPageSearchClient
    ) {
        $this->conditionalAvailabilityPageSearchClient = $conditionalAvailabilityPageSearchClient;
    }

    /**
     * @param string $searchString
     * @param array $requestParameters
     *
     * @return array
     */
    public function search(string $searchString, array $requestParameters = []): array
    {
        return $this->conditionalAvailabilityPageSearchClient->search($searchString, $requestParameters);
    }
}
