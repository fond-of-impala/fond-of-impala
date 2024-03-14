<?php

namespace FondOfImpala\Client\CompanyCurrencyPriceProductPriceListSearchRestApi;

use FondOfImpala\Client\CompanyCurrencyPriceProductPriceListSearchRestApi\Dependency\Client\CompanyCurrencyPriceProductPriceListSearchRestApiToZedRequestClientInterface;
use FondOfImpala\Client\CompanyCurrencyPriceProductPriceListSearchRestApi\Zed\CompanyCurrencyPriceProductPriceListSearchRestApiStub;
use FondOfImpala\Client\CompanyCurrencyPriceProductPriceListSearchRestApi\Zed\CompanyCurrencyPriceProductPriceListSearchRestApiStubInterface;
use Spryker\Client\Kernel\AbstractFactory;

class CompanyCurrencyPriceProductPriceListSearchRestApiFactory extends AbstractFactory
{
    /**
     * @return \FondOfImpala\Client\CompanyCurrencyPriceProductPriceListSearchRestApi\Zed\CompanyCurrencyPriceProductPriceListSearchRestApiStubInterface
     */
    public function createZedStub(): CompanyCurrencyPriceProductPriceListSearchRestApiStubInterface
    {
        return new CompanyCurrencyPriceProductPriceListSearchRestApiStub($this->getZedRequestClient());
    }

    /**
     * @return \FondOfImpala\Client\CompanyCurrencyPriceProductPriceListSearchRestApi\Dependency\Client\CompanyCurrencyPriceProductPriceListSearchRestApiToZedRequestClientInterface
     */
    protected function getZedRequestClient(): CompanyCurrencyPriceProductPriceListSearchRestApiToZedRequestClientInterface
    {
        return $this->getProvidedDependency(CompanyCurrencyPriceProductPriceListSearchRestApiDependencyProvider::CLIENT_ZED_REQUEST);
    }
}
