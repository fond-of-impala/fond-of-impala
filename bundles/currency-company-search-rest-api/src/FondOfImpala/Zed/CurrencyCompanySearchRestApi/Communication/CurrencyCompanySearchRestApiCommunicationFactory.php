<?php

namespace FondOfImpala\Zed\CurrencyCompanySearchRestApi\Communication;

use FondOfImpala\Zed\CurrencyCompanySearchRestApi\CurrencyCompanySearchRestApiDependencyProvider;
use FondOfImpala\Zed\CurrencyCompanySearchRestApi\Dependency\Facade\CurrencyCompanySearchRestApiToCurrencyFacadeInterface;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;

class CurrencyCompanySearchRestApiCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return \FondOfImpala\Zed\CurrencyCompanySearchRestApi\Dependency\Facade\CurrencyCompanySearchRestApiToCurrencyFacadeInterface
     */
    public function getCurrencyFacade(): CurrencyCompanySearchRestApiToCurrencyFacadeInterface
    {
        return $this->getProvidedDependency(CurrencyCompanySearchRestApiDependencyProvider::FACADE_CURRENCY);
    }
}
