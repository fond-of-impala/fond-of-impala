<?php

namespace FondOfImpala\Glue\CompanyCurrencyPriceProductPriceListSearchRestApi;

use FondOfImpala\Glue\CompanyCurrencyPriceProductPriceListSearchRestApi\Dependency\Client\CompanyCurrencyPriceProductPriceListSearchRestApiToCustomerClientInterface;
use Spryker\Glue\Kernel\AbstractFactory;

class CompanyCurrencyPriceProductPriceListSearchRestApiFactory extends AbstractFactory
{
    /**
     * @return \FondOfImpala\Glue\CompanyCurrencyPriceProductPriceListSearchRestApi\Dependency\Client\CompanyCurrencyPriceProductPriceListSearchRestApiToCustomerClientInterface
     */
    public function getCustomerClient(): CompanyCurrencyPriceProductPriceListSearchRestApiToCustomerClientInterface
    {
        return $this->getProvidedDependency(CompanyCurrencyPriceProductPriceListSearchRestApiDependencyProvider::CLIENT_CUSTOMER);
    }
}
