<?php

declare(strict_types = 1);

namespace FondOfImpala\Client\ConditionalAvailabilityProductPageSearch;

use FondOfImpala\Client\ConditionalAvailabilityProductPageSearch\Dependency\Client\ConditionalAvailabilityProductPageSearchToCustomerClientInterface;
use Spryker\Client\Kernel\AbstractFactory;

class ConditionalAvailabilityProductPageSearchFactory extends AbstractFactory
{
    /**
     * @return \FondOfImpala\Client\ConditionalAvailabilityProductPageSearch\Dependency\Client\ConditionalAvailabilityProductPageSearchToCustomerClientInterface
     */
    public function getCustomerClient(): ConditionalAvailabilityProductPageSearchToCustomerClientInterface
    {
        return $this->getProvidedDependency(ConditionalAvailabilityProductPageSearchDependencyProvider::CLIENT_CUSTOMER);
    }
}
