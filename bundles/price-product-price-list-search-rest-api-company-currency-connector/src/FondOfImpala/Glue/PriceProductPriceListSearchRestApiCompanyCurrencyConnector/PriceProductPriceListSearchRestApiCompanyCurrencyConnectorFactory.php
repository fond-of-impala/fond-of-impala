<?php

namespace FondOfImpala\Glue\PriceProductPriceListSearchRestApiCompanyCurrencyConnector;

use FondOfImpala\Glue\PriceProductPriceListSearchRestApiCompanyCurrencyConnector\Dependency\Client\PriceProductPriceListSearchRestApiCompanyCurrencyConnectorToCustomerClientInterface;
use Spryker\Glue\Kernel\AbstractFactory;

class PriceProductPriceListSearchRestApiCompanyCurrencyConnectorFactory extends AbstractFactory
{
    /**
     * @return \FondOfImpala\Glue\PriceProductPriceListSearchRestApiCompanyCurrencyConnector\Dependency\Client\PriceProductPriceListSearchRestApiCompanyCurrencyConnectorToCustomerClientInterface
     */
    public function getCustomerClient(): PriceProductPriceListSearchRestApiCompanyCurrencyConnectorToCustomerClientInterface
    {
        return $this->getProvidedDependency(PriceProductPriceListSearchRestApiCompanyCurrencyConnectorDependencyProvider::CLIENT_CUSTOMER);
    }
}
