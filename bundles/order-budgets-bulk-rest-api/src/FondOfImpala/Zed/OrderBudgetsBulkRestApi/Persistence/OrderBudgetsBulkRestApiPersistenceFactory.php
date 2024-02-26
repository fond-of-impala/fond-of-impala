<?php

namespace FondOfImpala\Zed\OrderBudgetsBulkRestApi\Persistence;

use FondOfImpala\Zed\OrderBudgetsBulkRestApi\OrderBudgetsBulkRestApiDependencyProvider;
use Orm\Zed\OrderBudget\Persistence\Base\FooOrderBudgetQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @codeCoverageIgnore
 */
class OrderBudgetsBulkRestApiPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\OrderBudget\Persistence\Base\FooOrderBudgetQuery
     */
    public function getOrderBudgetQuery(): FooOrderBudgetQuery
    {
        return $this->getProvidedDependency(OrderBudgetsBulkRestApiDependencyProvider::PROPEL_QUERY_ORDER_BUDGET);
    }
}
