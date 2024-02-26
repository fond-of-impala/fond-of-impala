<?php

namespace FondOfImpala\Zed\OrderBudgetsBulkRestApi\Persistence;

use Orm\Zed\OrderBudget\Persistence\Map\FooOrderBudgetTableMap;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @codeCoverageIgnore
 *
 * @method \FondOfImpala\Zed\OrderBudgetsBulkRestApi\Persistence\OrderBudgetsBulkRestApiPersistenceFactory getFactory()
 */
class OrderBudgetsBulkRestApiRepository extends AbstractRepository implements OrderBudgetsBulkRestApiRepositoryInterface
{
    /**
     * @param array<string> $uuids
     *
     * @return array<string, int>
     */
    public function getOrderBudgetIdsByUuids(array $uuids): array
    {
        /** @var \Propel\Runtime\Collection\ObjectCollection $collection */
        $collection = $this->getFactory()
            ->getOrderBudgetQuery()
            ->clear()
            ->filterByUuid_In($uuids)
            ->select([FooOrderBudgetTableMap::COL_ID_ORDER_BUDGET, FooOrderBudgetTableMap::COL_UUID])
            ->find();

        return $collection->toKeyValue(
            FooOrderBudgetTableMap::COL_UUID,
            FooOrderBudgetTableMap::COL_ID_ORDER_BUDGET,
        );
    }
}
