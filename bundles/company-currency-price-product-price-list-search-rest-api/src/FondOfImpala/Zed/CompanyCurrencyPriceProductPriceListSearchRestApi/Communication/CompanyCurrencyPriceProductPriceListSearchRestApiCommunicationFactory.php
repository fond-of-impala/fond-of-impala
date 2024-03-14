<?php

namespace FondOfImpala\Zed\CompanyCurrencyPriceProductPriceListSearchRestApi\Communication;

use FondOfImpala\Zed\CompanyCurrencyPriceProductPriceListSearchRestApi\CompanyCurrencyPriceProductPriceListSearchRestApiDependencyProvider;
use FondOfImpala\Zed\CompanyCurrencyPriceProductPriceListSearchRestApi\Dependency\Facade\CompanyCurrencyPriceProductPriceListSearchRestApiToCurrencyFacadeInterface;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;

class CompanyCurrencyPriceProductPriceListSearchRestApiCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return \FondOfImpala\Zed\CompanyCurrencyPriceProductPriceListSearchRestApi\Dependency\Facade\CompanyCurrencyPriceProductPriceListSearchRestApiToCurrencyFacadeInterface
     */
    public function getCurrencyFacade(): CompanyCurrencyPriceProductPriceListSearchRestApiToCurrencyFacadeInterface
    {
        return $this->getProvidedDependency(CompanyCurrencyPriceProductPriceListSearchRestApiDependencyProvider::FACADE_CURRENCY);
    }
}
