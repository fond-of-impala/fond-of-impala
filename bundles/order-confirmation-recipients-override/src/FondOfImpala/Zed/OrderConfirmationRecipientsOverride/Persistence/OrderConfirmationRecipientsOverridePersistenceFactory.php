<?php

namespace FondOfImpala\Zed\OrderConfirmationRecipientsOverride\Persistence;

use FondOfImpala\Zed\OrderConfirmationRecipientsOverride\OrderConfirmationRecipientsOverrideDependencyProvider;
use Orm\Zed\Customer\Persistence\SpyCustomerQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @codeCoverageIgnore
 */
class OrderConfirmationRecipientsOverridePersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\Customer\Persistence\SpyCustomerQuery
     */
    public function getCustomerQuery(): SpyCustomerQuery
    {
        return $this->getProvidedDependency(OrderConfirmationRecipientsOverrideDependencyProvider::PROPEL_QUERY_CUSTOMER);
    }
}
