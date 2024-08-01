<?php

namespace FondOfImpala\Zed\OrderConfirmationOverride\Persistence;

use FondOfImpala\Zed\OrderConfirmationOverride\OrderConfirmationOverrideDependencyProvider;
use Orm\Zed\Customer\Persistence\SpyCustomerQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @codeCoverageIgnore
 */
class OrderConfirmationOverridePersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\Customer\Persistence\SpyCustomerQuery
     */
    public function getCustomerQuery(): SpyCustomerQuery
    {
        return $this->getProvidedDependency(OrderConfirmationOverrideDependencyProvider::PROPEL_QUERY_CUSTOMER);
    }
}
