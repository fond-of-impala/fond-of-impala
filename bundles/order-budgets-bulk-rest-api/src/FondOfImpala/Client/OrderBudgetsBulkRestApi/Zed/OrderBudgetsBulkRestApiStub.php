<?php

namespace FondOfImpala\Client\OrderBudgetsBulkRestApi\Zed;

use FondOfImpala\Client\OrderBudgetsBulkRestApi\Dependency\Client\OrderBudgetsBulkRestApiToZedRequestClientInterface;
use Generated\Shared\Transfer\RestOrderBudgetsBulkRequestTransfer;
use Generated\Shared\Transfer\RestOrderBudgetsBulkResponseTransfer;

class OrderBudgetsBulkRestApiStub implements OrderBudgetsBulkRestApiStubInterface
{
    /**
     * @var string
     */
    public const BULK_PROCESS = '/order-budgets-bulk-rest-api/gateway/bulk-process';

    protected OrderBudgetsBulkRestApiToZedRequestClientInterface $zedRequestClient;

    /**
     * @param \FondOfImpala\Client\OrderBudgetsBulkRestApi\Dependency\Client\OrderBudgetsBulkRestApiToZedRequestClientInterface $zedRequestClient
     */
    public function __construct(OrderBudgetsBulkRestApiToZedRequestClientInterface $zedRequestClient)
    {
        $this->zedRequestClient = $zedRequestClient;
    }

    /**
     * @param \Generated\Shared\Transfer\RestOrderBudgetsBulkRequestTransfer $restOrderBudgetsBulkRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestOrderBudgetsBulkResponseTransfer
     */
    public function bulkProcess(
        RestOrderBudgetsBulkRequestTransfer $restOrderBudgetsBulkRequestTransfer
    ): RestOrderBudgetsBulkResponseTransfer {
        /** @var \Generated\Shared\Transfer\RestOrderBudgetsBulkResponseTransfer $restOrderBudgetsBulkResponseTransfer */
        $restOrderBudgetsBulkResponseTransfer = $this->zedRequestClient->call(
            static::BULK_PROCESS,
            $restOrderBudgetsBulkRequestTransfer,
        );

        return $restOrderBudgetsBulkResponseTransfer;
    }
}
