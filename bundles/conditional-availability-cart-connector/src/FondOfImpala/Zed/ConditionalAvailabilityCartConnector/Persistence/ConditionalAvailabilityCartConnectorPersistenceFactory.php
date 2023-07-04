<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Persistence;

use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\ConditionalAvailabilityCartConnectorDependencyProvider;
use Orm\Zed\Customer\Persistence\Base\SpyCustomerQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @codeCoverageIgnore
 */
class ConditionalAvailabilityCartConnectorPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\Customer\Persistence\Base\SpyCustomerQuery
     */
    public function getCustomerQuery(): SpyCustomerQuery
    {
        return $this->getProvidedDependency(
            ConditionalAvailabilityCartConnectorDependencyProvider::PROPEL_QUERY_CUSTOMER,
        );
    }
}
