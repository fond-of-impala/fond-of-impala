<?php

namespace FondOfImpala\Glue\ConditionalAvailabilityCartConnector;

use FondOfImpala\Service\ConditionalAvailabilityCartConnector\ConditionalAvailabilityCartConnectorService;
use FondOfImpala\Service\ConditionalAvailabilityCartConnector\ConditionalAvailabilityCartConnectorServiceInterface;
use Spryker\Glue\Kernel\AbstractFactory;

class ConditionalAvailabilityCartConnectorFactory extends AbstractFactory
{
    /**
     * @return \FondOfImpala\Service\ConditionalAvailabilityCartConnector\ConditionalAvailabilityCartConnectorServiceInterface
     */
    public function getService(): ConditionalAvailabilityCartConnectorServiceInterface
    {
        return new ConditionalAvailabilityCartConnectorService();
    }
}
