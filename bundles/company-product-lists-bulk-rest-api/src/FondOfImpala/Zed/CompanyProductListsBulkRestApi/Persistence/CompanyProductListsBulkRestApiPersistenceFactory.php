<?php

namespace FondOfImpala\Zed\CompanyProductListsBulkRestApi\Persistence;

use FondOfImpala\Zed\CompanyProductListsBulkRestApi\CompanyProductListsBulkRestApiDependencyProvider;
use Orm\Zed\Company\Persistence\Base\SpyCompanyQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @codeCoverageIgnore
 */
class CompanyProductListsBulkRestApiPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\Company\Persistence\Base\SpyCompanyQuery
     */
    public function getCompanyQuery(): SpyCompanyQuery
    {
        return $this->getProvidedDependency(CompanyProductListsBulkRestApiDependencyProvider::PROPEL_QUERY_COMPANY);
    }
}
