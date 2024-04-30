<?php

namespace FondOfImpala\Zed\CompanyUserSearchCompanyType\Persistence;

use FondOfImpala\Zed\CompanyUserSearchCompanyType\CompanyUserSearchCompanyTypeDependencyProvider;
use Orm\Zed\Company\Persistence\Base\SpyCompanyQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

class CompanyUserSearchCompanyTypePersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\Company\Persistence\Base\SpyCompanyQuery
     */
    public function getCompanyQuery(): SpyCompanyQuery
    {
        return $this->getProvidedDependency(
            CompanyUserSearchCompanyTypeDependencyProvider::PROPEL_QUERY_COMPANY,
        );
    }
}
