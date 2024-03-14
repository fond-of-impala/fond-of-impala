<?php

namespace FondOfImpala\Zed\CompanyCurrencyCompanyUserCartsRestApi\Communication;

use FondOfImpala\Zed\CompanyCurrencyCompanyUserCartsRestApi\CompanyCurrencyCompanyUserCartsRestApiDependencyProvider;
use FondOfImpala\Zed\CompanyCurrencyCompanyUserCartsRestApi\Dependency\Facade\CompanyCurrencyCompanyUserCartsRestApiToCurrencyFacadeInterface;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;

class CompanyCurrencyCompanyUserCartsRestApiCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return \FondOfImpala\Zed\CompanyCurrencyCompanyUserCartsRestApi\Dependency\Facade\CompanyCurrencyCompanyUserCartsRestApiToCurrencyFacadeInterface
     */
    public function getCurrencyFacade(): CompanyCurrencyCompanyUserCartsRestApiToCurrencyFacadeInterface
    {
        return $this->getProvidedDependency(CompanyCurrencyCompanyUserCartsRestApiDependencyProvider::FACADE_CURRENCY);
    }
}
