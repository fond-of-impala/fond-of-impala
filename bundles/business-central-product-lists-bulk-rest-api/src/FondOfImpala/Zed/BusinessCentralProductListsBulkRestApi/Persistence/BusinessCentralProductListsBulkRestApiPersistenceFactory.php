<?php

namespace FondOfImpala\Zed\BusinessCentralProductListsBulkRestApi\Persistence;

use FondOfImpala\Zed\BusinessCentralProductListsBulkRestApi\BusinessCentralProductListsBulkRestApiDependencyProvider;
use Orm\Zed\Company\Persistence\Base\SpyCompanyQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @codeCoverageIgnore
 */
class BusinessCentralProductListsBulkRestApiPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\Company\Persistence\Base\SpyCompanyQuery
     */
    public function getCompanyQuery(): SpyCompanyQuery
    {
        return $this->getProvidedDependency(BusinessCentralProductListsBulkRestApiDependencyProvider::PROPEL_QUERY_COMPANY);
    }
}
