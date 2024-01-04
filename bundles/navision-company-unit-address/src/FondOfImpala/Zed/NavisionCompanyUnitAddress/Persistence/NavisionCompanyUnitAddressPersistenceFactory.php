<?php

namespace FondOfImpala\Zed\NavisionCompanyUnitAddress\Persistence;

use FondOfImpala\Zed\NavisionCompanyUnitAddress\NavisionCompanyUnitAddressDependencyProvider;
use Orm\Zed\CompanyUnitAddress\Persistence\SpyCompanyUnitAddressQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \FondOfImpala\Zed\NavisionCompanyUnitAddress\NavisionCompanyUnitAddressConfig getConfig()
 * @method \FondOfImpala\Zed\NavisionCompanyUnitAddress\Persistence\NavisionCompanyUnitAddressRepositoryInterface getRepository()
 */
class NavisionCompanyUnitAddressPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\CompanyUnitAddress\Persistence\SpyCompanyUnitAddressQuery
     */
    public function getCompanyUnitAddressQuery(): SpyCompanyUnitAddressQuery
    {
        return $this->getProvidedDependency(NavisionCompanyUnitAddressDependencyProvider::PROPEL_QUERY_COMPANY_UNIT_ADDRESS);
    }
}
