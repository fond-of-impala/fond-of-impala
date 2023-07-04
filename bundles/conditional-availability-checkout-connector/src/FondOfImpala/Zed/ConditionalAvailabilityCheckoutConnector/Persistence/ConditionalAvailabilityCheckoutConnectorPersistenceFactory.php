<?php

namespace FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\Persistence;

use FondOfImpala\Zed\ConditionalAvailabilityCheckoutConnector\ConditionalAvailabilityCheckoutConnectorDependencyProvider;
use Orm\Zed\Customer\Persistence\Base\SpyCustomerQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

class ConditionalAvailabilityCheckoutConnectorPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\Customer\Persistence\Base\SpyCustomerQuery
     */
    public function getCustomerQuery(): SpyCustomerQuery
    {
        return $this->getProvidedDependency(
            ConditionalAvailabilityCheckoutConnectorDependencyProvider::PROPEL_QUERY_CUSTOMER,
        );
    }
}
