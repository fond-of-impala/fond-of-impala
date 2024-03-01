<?php

namespace FondOfImpala\Zed\CompanyTypeProductListsBulkRestApi\Persistence;

use FondOfImpala\Zed\CompanyTypeProductListsBulkRestApi\CompanyTypeProductListsBulkRestApiDependencyProvider;
use Orm\Zed\Customer\Persistence\Base\SpyCustomerQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @codeCoverageIgnore
 */
class CompanyTypeProductListsBulkRestApiPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\Customer\Persistence\Base\SpyCustomerQuery
     */
    public function getCustomerQuery(): SpyCustomerQuery
    {
        return $this->getProvidedDependency(CompanyTypeProductListsBulkRestApiDependencyProvider::PROPEL_QUERY_CUSTOMER);
    }
}
