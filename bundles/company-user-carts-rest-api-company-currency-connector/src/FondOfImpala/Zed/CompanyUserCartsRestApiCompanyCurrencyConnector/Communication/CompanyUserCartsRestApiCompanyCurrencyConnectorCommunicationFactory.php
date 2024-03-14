<?php

namespace FondOfImpala\Zed\CompanyUserCartsRestApiCompanyCurrencyConnector\Communication;

use FondOfImpala\Zed\CompanyUserCartsRestApiCompanyCurrencyConnector\CompanyUserCartsRestApiCompanyCurrencyConnectorDependencyProvider;
use FondOfImpala\Zed\CompanyUserCartsRestApiCompanyCurrencyConnector\Dependency\Facade\CompanyUserCartsRestApiCompanyCurrencyConnectorToCurrencyFacadeInterface;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;

class CompanyUserCartsRestApiCompanyCurrencyConnectorCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return \FondOfImpala\Zed\CompanyUserCartsRestApiCompanyCurrencyConnector\Dependency\Facade\CompanyUserCartsRestApiCompanyCurrencyConnectorToCurrencyFacadeInterface
     */
    public function getCurrencyFacade(): CompanyUserCartsRestApiCompanyCurrencyConnectorToCurrencyFacadeInterface
    {
        return $this->getProvidedDependency(CompanyUserCartsRestApiCompanyCurrencyConnectorDependencyProvider::FACADE_CURRENCY);
    }
}
