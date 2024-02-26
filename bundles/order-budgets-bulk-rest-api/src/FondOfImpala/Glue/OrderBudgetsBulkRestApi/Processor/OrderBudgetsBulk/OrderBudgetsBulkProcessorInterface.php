<?php

namespace FondOfImpala\Glue\OrderBudgetsBulkRestApi\Processor\OrderBudgetsBulk;

use Generated\Shared\Transfer\RestOrderBudgetsBulkRequestAttributesTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

interface OrderBudgetsBulkProcessorInterface
{
    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     * @param \Generated\Shared\Transfer\RestOrderBudgetsBulkRequestAttributesTransfer $restOrderBudgetsBulkRequestAttributesTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function process(
        RestRequestInterface $restRequest,
        RestOrderBudgetsBulkRequestAttributesTransfer $restOrderBudgetsBulkRequestAttributesTransfer
    ): RestResponseInterface;
}
