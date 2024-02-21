<?php

namespace FondOfImpala\Zed\OrderBudgetsBulkRestApi\Business\Reader;

interface OrderBudgetReaderInterface
{
    /**
     * @param array<string> $uuids
     *
     * @return array<int>
     */
    public function getIdsByUuids(array $uuids): array;
}
