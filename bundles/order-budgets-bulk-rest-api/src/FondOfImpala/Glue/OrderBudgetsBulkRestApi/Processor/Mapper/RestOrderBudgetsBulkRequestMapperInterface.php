<?php

namespace FondOfImpala\Glue\OrderBudgetsBulkRestApi\Processor\Mapper;

use Generated\Shared\Transfer\RestOrderBudgetsBulkRequestAttributesTransfer;
use Generated\Shared\Transfer\RestOrderBudgetsBulkRequestTransfer;

interface RestOrderBudgetsBulkRequestMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestOrderBudgetsBulkRequestAttributesTransfer $restOrderBudgetsBulkRequestAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\RestOrderBudgetsBulkRequestTransfer
     */
    public function fromRestOrderBudgetsBulkRequestAttributes(
        RestOrderBudgetsBulkRequestAttributesTransfer $restOrderBudgetsBulkRequestAttributesTransfer
    ): RestOrderBudgetsBulkRequestTransfer;
}
