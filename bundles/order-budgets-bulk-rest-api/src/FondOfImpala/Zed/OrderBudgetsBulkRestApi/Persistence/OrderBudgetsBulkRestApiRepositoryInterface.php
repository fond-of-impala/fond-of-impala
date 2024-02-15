<?php

namespace FondOfImpala\Zed\OrderBudgetsBulkRestApi\Persistence;

interface OrderBudgetsBulkRestApiRepositoryInterface
{
    /**
     * @param array<string> $uuids
     *
     * @return array<string, int>
     */
    public function getOrderBudgetIdsByUuids(array $uuids): array;
}
