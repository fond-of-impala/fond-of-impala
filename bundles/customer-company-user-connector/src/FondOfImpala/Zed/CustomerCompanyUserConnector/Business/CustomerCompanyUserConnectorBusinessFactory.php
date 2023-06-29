<?php

declare(strict_types = 1);

namespace FondOfImpala\Zed\CustomerCompanyUserConnector\Business;

use FondOfImpala\Zed\CustomerCompanyUserConnector\Business\Model\CompanyUserDeleter;
use FondOfImpala\Zed\CustomerCompanyUserConnector\Business\Model\CompanyUserDeleterInterface;
use FondOfImpala\Zed\CustomerCompanyUserConnector\CustomerCompanyUserConnectorDependencyProvider;
use FondOfImpala\Zed\CustomerCompanyUserConnector\Dependency\Facade\CustomerCompanyUserConnectorToCompanyUserFacadeInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfImpala\Zed\CustomerCompanyUserConnector\Business\CustomerCompanyUserConnectorFacadeInterface getFacade()
 * @method \FondOfImpala\Zed\CustomerCompanyUserConnector\Persistence\CustomerCompanyUserConnectorRepositoryInterface getRepository()
 */
class CustomerCompanyUserConnectorBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfImpala\Zed\CustomerCompanyUserConnector\Business\Model\CompanyUserDeleterInterface
     */
    public function createCompanyUserDeleter(): CompanyUserDeleterInterface
    {
        return new CompanyUserDeleter(
            $this->getCompanyUserFacade(),
            $this->getRepository(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CustomerCompanyUserConnector\Dependency\Facade\CustomerCompanyUserConnectorToCompanyUserFacadeInterface
     */
    protected function getCompanyUserFacade(): CustomerCompanyUserConnectorToCompanyUserFacadeInterface
    {
        return $this->getProvidedDependency(
            CustomerCompanyUserConnectorDependencyProvider::FACADE_COMPANY_USER,
        );
    }
}
