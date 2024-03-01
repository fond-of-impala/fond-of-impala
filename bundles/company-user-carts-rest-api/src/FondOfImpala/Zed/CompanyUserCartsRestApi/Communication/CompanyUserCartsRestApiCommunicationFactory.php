<?php

namespace FondOfImpala\Zed\CompanyUserCartsRestApi\Communication;

use FondOfImpala\Zed\CompanyUserCartsRestApi\CompanyUserCartsRestApiDependencyProvider;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Dependency\Facade\CompanyUserCartsRestApiToCurrencyFacadeInterface;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;

/**
 * @method \FondOfImpala\Zed\CompanyUserCartsRestApi\CompanyUserCartsRestApiConfig getConfig()
 */
class CompanyUserCartsRestApiCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return \FondOfImpala\Zed\CompanyUserCartsRestApi\Dependency\Facade\CompanyUserCartsRestApiToCurrencyFacadeInterface
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    public function getCurrencyFacade(): CompanyUserCartsRestApiToCurrencyFacadeInterface
    {
        return $this->getProvidedDependency(CompanyUserCartsRestApiDependencyProvider::FACADE_CURRENCY);
    }
}
