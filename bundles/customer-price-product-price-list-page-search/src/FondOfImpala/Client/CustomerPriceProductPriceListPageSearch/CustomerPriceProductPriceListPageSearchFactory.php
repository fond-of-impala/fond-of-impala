<?php

namespace FondOfImpala\Client\CustomerPriceProductPriceListPageSearch;

use FondOfImpala\Client\CustomerPriceProductPriceListPageSearch\Dependency\Client\CustomerPriceProductPriceListPageSearchToCustomerClientInterface;
use Spryker\Client\Kernel\AbstractFactory;

class CustomerPriceProductPriceListPageSearchFactory extends AbstractFactory
{
    /**
     * @return \FondOfImpala\Client\CustomerPriceProductPriceListPageSearch\Dependency\Client\CustomerPriceProductPriceListPageSearchToCustomerClientInterface
     */
    public function getCustomerClient(): CustomerPriceProductPriceListPageSearchToCustomerClientInterface
    {
        return $this->getProvidedDependency(CustomerPriceProductPriceListPageSearchDependencyProvider::CLIENT_CUSTOMER);
    }
}
