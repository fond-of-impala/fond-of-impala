<?php

declare(strict_types = 1);

namespace FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Business;

use FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Business\Model\CompanyUserDeleter;
use FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Business\Model\CompanyUserDeleterInterface;
use FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\CustomerAnonymizerCompanyUserConnectorDependencyProvider;
use FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Dependency\Facade\CustomerAnonymizerCompanyUserConnectorToCompanyUserFacadeInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Business\CustomerAnonymizerCompanyUserConnectorFacadeInterface getFacade()
 * @method \FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Persistence\CustomerAnonymizerCompanyUserConnectorRepositoryInterface getRepository()
 */
class CustomerAnonymizerCompanyUserConnectorBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Business\Model\CompanyUserDeleterInterface
     */
    public function createCompanyUserDeleter(): CompanyUserDeleterInterface
    {
        return new CompanyUserDeleter(
            $this->getCompanyUserFacade(),
            $this->getRepository(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CustomerAnonymizerCompanyUserConnector\Dependency\Facade\CustomerAnonymizerCompanyUserConnectorToCompanyUserFacadeInterface
     */
    protected function getCompanyUserFacade(): CustomerAnonymizerCompanyUserConnectorToCompanyUserFacadeInterface
    {
        return $this->getProvidedDependency(
            CustomerAnonymizerCompanyUserConnectorDependencyProvider::FACADE_COMPANY_USER,
        );
    }
}
