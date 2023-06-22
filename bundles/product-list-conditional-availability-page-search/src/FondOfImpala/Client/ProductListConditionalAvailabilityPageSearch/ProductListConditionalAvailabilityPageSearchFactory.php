<?php

namespace FondOfImpala\Client\ProductListConditionalAvailabilityPageSearch;

use FondOfImpala\Client\ProductListConditionalAvailabilityPageSearch\Dependency\Client\ProductListConditionalAvailabilityPageSearchToCustomerClientInterface;
use Spryker\Client\Kernel\AbstractFactory;

class ProductListConditionalAvailabilityPageSearchFactory extends AbstractFactory
{
    /**
     * @return \FondOfImpala\Client\ProductListConditionalAvailabilityPageSearch\Dependency\Client\ProductListConditionalAvailabilityPageSearchToCustomerClientInterface
     */
    public function getCustomerClient(): ProductListConditionalAvailabilityPageSearchToCustomerClientInterface
    {
        return $this->getProvidedDependency(
            ProductListConditionalAvailabilityPageSearchDependencyProvider::CLIENT_CUSTOMER,
        );
    }
}
