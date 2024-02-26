<?php

namespace FondOfImpala\Zed\OrderBudgetsBulkRestApi\Business\Reader;

use FondOfImpala\Zed\OrderBudgetsBulkRestApi\Persistence\OrderBudgetsBulkRestApiRepositoryInterface;

class OrderBudgetReader implements OrderBudgetReaderInterface
{
    protected OrderBudgetsBulkRestApiRepositoryInterface $repository;

    /**
     * @param \FondOfImpala\Zed\OrderBudgetsBulkRestApi\Persistence\OrderBudgetsBulkRestApiRepositoryInterface $repository
     */
    public function __construct(OrderBudgetsBulkRestApiRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param array<string> $uuids
     *
     * @return array<string, int>
     */
    public function getIdsByUuids(array $uuids): array
    {
        return $this->repository->getOrderBudgetIdsByUuids($uuids);
    }
}
