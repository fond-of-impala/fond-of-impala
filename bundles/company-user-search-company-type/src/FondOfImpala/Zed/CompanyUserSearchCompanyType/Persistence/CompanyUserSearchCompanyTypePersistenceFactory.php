<?php

namespace FondOfImpala\Zed\CompanyUserSearchCompanyType\Persistence;

use FondOfImpala\Zed\BusinessCentralOrderBudgetsBulkRestApi\BusinessCentralOrderBudgetsBulkRestApiDependencyProvider;
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
            BusinessCentralOrderBudgetsBulkRestApiDependencyProvider::PROPEL_QUERY_COMPANY,
        );
    }
}
