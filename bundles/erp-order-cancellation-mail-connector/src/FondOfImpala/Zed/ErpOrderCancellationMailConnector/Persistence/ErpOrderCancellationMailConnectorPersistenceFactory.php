<?php

namespace FondOfImpala\Zed\ErpOrderCancellationMailConnector\Persistence;

use FondOfImpala\Zed\ErpOrderCancellationMailConnector\ErpOrderCancellationMailConnectorDependencyProvider;
use Orm\Zed\Company\Persistence\SpyCompanyQuery;
use Orm\Zed\CompanyRole\Persistence\SpyCompanyRoleQuery;
use Orm\Zed\Customer\Persistence\SpyCustomerQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @codeCoverageIgnore
 *
 * @method \FondOfImpala\Zed\ErpOrderCancellationMailConnector\Persistence\ErpOrderCancellationMailConnectorEntityManagerInterface getEntityManager()
 * @method \FondOfImpala\Zed\ErpOrderCancellationMailConnector\Persistence\ErpOrderCancellationMailConnectorRepositoryInterface getRepository()
 */
class ErpOrderCancellationMailConnectorPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\Company\Persistence\SpyCompanyQuery
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    public function getCompanyQuery(): SpyCompanyQuery
    {
        return $this->getProvidedDependency(ErpOrderCancellationMailConnectorDependencyProvider::PROPEL_QUERY_COMPANY);
    }

    /**
     * @return \Orm\Zed\CompanyRole\Persistence\SpyCompanyRoleQuery
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    public function getCompanyRoleQuery(): SpyCompanyRoleQuery
    {
        return $this->getProvidedDependency(ErpOrderCancellationMailConnectorDependencyProvider::PROPEL_QUERY_COMPANY_ROLE);
    }

    /**
     * @return \Orm\Zed\Customer\Persistence\SpyCustomerQuery
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    public function getCustomerQuery(): SpyCustomerQuery
    {
        return $this->getProvidedDependency(ErpOrderCancellationMailConnectorDependencyProvider::PROPEL_QUERY_CUSTOMER);
    }
}
