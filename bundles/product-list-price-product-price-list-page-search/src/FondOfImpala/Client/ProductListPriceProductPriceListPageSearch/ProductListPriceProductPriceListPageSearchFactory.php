<?php

namespace FondOfImpala\Client\ProductListPriceProductPriceListPageSearch;

use FondOfImpala\Client\ProductListPriceProductPriceListPageSearch\Dependency\Client\ProductListPriceProductPriceListPageSearchToCustomerClientInterface;
use Spryker\Client\Kernel\AbstractFactory;

class ProductListPriceProductPriceListPageSearchFactory extends AbstractFactory
{
    /**
     * @return \FondOfImpala\Client\ProductListPriceProductPriceListPageSearch\Dependency\Client\ProductListPriceProductPriceListPageSearchToCustomerClientInterface
     */
    public function getCustomerClient(): ProductListPriceProductPriceListPageSearchToCustomerClientInterface
    {
        return $this->getProvidedDependency(
            ProductListPriceProductPriceListPageSearchDependencyProvider::CLIENT_CUSTOMER,
        );
    }
}
