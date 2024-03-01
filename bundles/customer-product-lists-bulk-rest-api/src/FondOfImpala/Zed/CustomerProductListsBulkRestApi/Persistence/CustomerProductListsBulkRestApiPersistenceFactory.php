<?php

namespace FondOfImpala\Zed\CustomerProductListsBulkRestApi\Persistence;

use FondOfImpala\Zed\CustomerProductListsBulkRestApi\CustomerProductListsBulkRestApiDependencyProvider;
use Orm\Zed\Customer\Persistence\Base\SpyCustomerQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @codeCoverageIgnore
 */
class CustomerProductListsBulkRestApiPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\Customer\Persistence\Base\SpyCustomerQuery
     */
    public function getCustomerQuery(): SpyCustomerQuery
    {
        return $this->getProvidedDependency(CustomerProductListsBulkRestApiDependencyProvider::PROPEL_QUERY_CUSTOMER);
    }
}
