<?php

namespace FondOfImpala\Glue\OrderBudgetsBulkRestApi\Processor\Builder;

use Generated\Shared\Transfer\RestOrderBudgetsBulkResponseTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;

interface RestResponseBuilderInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestOrderBudgetsBulkResponseTransfer $restOrderBudgetsBulkResponseTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function buildRestResponseByRestOrderBudgetsBulkResponse(
        RestOrderBudgetsBulkResponseTransfer $restOrderBudgetsBulkResponseTransfer
    ): RestResponseInterface;
}
