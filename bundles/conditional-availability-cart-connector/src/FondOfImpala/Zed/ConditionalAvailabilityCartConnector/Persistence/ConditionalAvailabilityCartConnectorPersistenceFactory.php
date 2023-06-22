<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Persistence;

use FondOfImpala\Zed\ConditionalAvailabilityCartConnector\ConditionalAvailabilityCartConnectorDependencyProvider;
use Orm\Zed\Customer\Persistence\SpyCustomerQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\ConditionalAvailabilityCartConnectorConfig getConfig()
 * @method \FondOfImpala\Zed\ConditionalAvailabilityCartConnector\Persistence\ConditionalAvailabilityCartConnectorRepositoryInterface getRepository()
 */
class ConditionalAvailabilityCartConnectorPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\Customer\Persistence\SpyCustomerQuery
     */
    public function getCustomerQuery(): SpyCustomerQuery
    {
        return $this->getProvidedDependency(
            ConditionalAvailabilityCartConnectorDependencyProvider::PROPEL_QUERY_CUSTOMER,
        );
    }
}
