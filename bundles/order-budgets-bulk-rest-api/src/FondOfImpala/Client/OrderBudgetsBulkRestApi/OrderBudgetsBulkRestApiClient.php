<?php

namespace FondOfImpala\Client\OrderBudgetsBulkRestApi;

use Generated\Shared\Transfer\RestOrderBudgetsBulkRequestTransfer;
use Generated\Shared\Transfer\RestOrderBudgetsBulkResponseTransfer;
use Spryker\Client\Kernel\AbstractClient;

/**
 * @method \FondOfImpala\Client\OrderBudgetsBulkRestApi\OrderBudgetsBulkRestApiFactory getFactory()
 */
class OrderBudgetsBulkRestApiClient extends AbstractClient implements OrderBudgetsBulkRestApiClientInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestOrderBudgetsBulkRequestTransfer $restOrderBudgetsBulkRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestOrderBudgetsBulkResponseTransfer
     */
    public function bulkProcess(
        RestOrderBudgetsBulkRequestTransfer $restOrderBudgetsBulkRequestTransfer
    ): RestOrderBudgetsBulkResponseTransfer {
        return $this->getFactory()
            ->createZedOrderBudgetsBulkRestApiStub()
            ->bulkProcess($restOrderBudgetsBulkRequestTransfer);
    }
}
