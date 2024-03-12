<?php

namespace FondOfImpala\Client\PriceProductPriceListSearchRestApiCompanyCurrencyConnector;

use FondOfImpala\Client\PriceProductPriceListSearchRestApiCompanyCurrencyConnector\Dependency\Client\PriceProductPriceListSearchRestApiCompanyCurrencyConnectorToZedRequestClientInterface;
use FondOfImpala\Client\PriceProductPriceListSearchRestApiCompanyCurrencyConnector\Zed\PriceProductPriceListSearchRestApiCompanyCurrencyConnectorStub;
use FondOfImpala\Client\PriceProductPriceListSearchRestApiCompanyCurrencyConnector\Zed\PriceProductPriceListSearchRestApiCompanyCurrencyConnectorStubInterface;
use Spryker\Client\Kernel\AbstractFactory;

class PriceProductPriceListSearchRestApiCompanyCurrencyConnectorFactory extends AbstractFactory
{
    /**
     * @return \FondOfImpala\Client\PriceProductPriceListSearchRestApiCompanyCurrencyConnector\Zed\PriceProductPriceListSearchRestApiCompanyCurrencyConnectorStubInterface
     */
    public function createZedStub(): PriceProductPriceListSearchRestApiCompanyCurrencyConnectorStubInterface
    {
        return new PriceProductPriceListSearchRestApiCompanyCurrencyConnectorStub($this->getZedRequestClient());
    }

    /**
     * @return \FondOfImpala\Client\PriceProductPriceListSearchRestApiCompanyCurrencyConnector\Dependency\Client\PriceProductPriceListSearchRestApiCompanyCurrencyConnectorToZedRequestClientInterface
     */
    protected function getZedRequestClient(): PriceProductPriceListSearchRestApiCompanyCurrencyConnectorToZedRequestClientInterface
    {
        return $this->getProvidedDependency(PriceProductPriceListSearchRestApiCompanyCurrencyConnectorDependencyProvider::CLIENT_ZED_REQUEST);
    }
}
