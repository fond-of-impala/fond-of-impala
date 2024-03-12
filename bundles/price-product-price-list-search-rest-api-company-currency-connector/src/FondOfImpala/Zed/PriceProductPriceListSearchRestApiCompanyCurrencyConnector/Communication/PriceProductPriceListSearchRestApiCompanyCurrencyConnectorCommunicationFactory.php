<?php

namespace FondOfImpala\Zed\PriceProductPriceListSearchRestApiCompanyCurrencyConnector\Communication;

use FondOfImpala\Zed\PriceProductPriceListSearchRestApiCompanyCurrencyConnector\Dependency\Facade\PriceProductPriceListSearchRestApiCompanyCurrencyConnectorToCurrencyFacadeInterface;
use FondOfImpala\Zed\PriceProductPriceListSearchRestApiCompanyCurrencyConnector\PriceProductPriceListSearchRestApiCompanyCurrencyConnectorDependencyProvider;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;

class PriceProductPriceListSearchRestApiCompanyCurrencyConnectorCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return \FondOfImpala\Zed\PriceProductPriceListSearchRestApiCompanyCurrencyConnector\Dependency\Facade\PriceProductPriceListSearchRestApiCompanyCurrencyConnectorToCurrencyFacadeInterface
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    public function getCurrencyFacade(): PriceProductPriceListSearchRestApiCompanyCurrencyConnectorToCurrencyFacadeInterface
    {
        return $this->getProvidedDependency(PriceProductPriceListSearchRestApiCompanyCurrencyConnectorDependencyProvider::FACADE_CURRENCY);
    }
}
