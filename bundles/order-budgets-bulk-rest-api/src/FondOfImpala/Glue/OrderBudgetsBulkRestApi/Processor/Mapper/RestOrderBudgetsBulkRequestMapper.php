<?php

namespace FondOfImpala\Glue\OrderBudgetsBulkRestApi\Processor\Mapper;

use Generated\Shared\Transfer\RestOrderBudgetsBulkRequestAttributesTransfer;
use Generated\Shared\Transfer\RestOrderBudgetsBulkRequestTransfer;

class RestOrderBudgetsBulkRequestMapper implements RestOrderBudgetsBulkRequestMapperInterface
{
    protected RestOrderBudgetsBulkRequestOrderBudgetMapperInterface $restOrderBudgetsBulkRequestOrderBudgetMapper;

    /**
     * @param \FondOfImpala\Glue\OrderBudgetsBulkRestApi\Processor\Mapper\RestOrderBudgetsBulkRequestOrderBudgetMapperInterface $restOrderBudgetsBulkRequestOrderBudgetMapper
     */
    public function __construct(
        RestOrderBudgetsBulkRequestOrderBudgetMapperInterface $restOrderBudgetsBulkRequestOrderBudgetMapper
    ) {
        $this->restOrderBudgetsBulkRequestOrderBudgetMapper = $restOrderBudgetsBulkRequestOrderBudgetMapper;
    }

    /**
     * @param \Generated\Shared\Transfer\RestOrderBudgetsBulkRequestAttributesTransfer $restOrderBudgetsBulkRequestAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\RestOrderBudgetsBulkRequestTransfer
     */
    public function fromRestOrderBudgetsBulkRequestAttributes(
        RestOrderBudgetsBulkRequestAttributesTransfer $restOrderBudgetsBulkRequestAttributesTransfer
    ): RestOrderBudgetsBulkRequestTransfer {
        $restOrderBudgetsBulkRequestTransfer = (new RestOrderBudgetsBulkRequestTransfer());
        $restOrderBudgetsBulkOrderBudgetTransfers = $restOrderBudgetsBulkRequestAttributesTransfer->getOrderBudgets();

        foreach ($restOrderBudgetsBulkOrderBudgetTransfers as $restOrderBudgetsBulkOrderBudgetTransfer) {
            $restOrderBudgetsBulkRequestOrderBudgetTransfer = $this->restOrderBudgetsBulkRequestOrderBudgetMapper
                ->fromRestOrderBudgetsBulkOrderBudget($restOrderBudgetsBulkOrderBudgetTransfer);

            $restOrderBudgetsBulkRequestTransfer->addOrderBudget($restOrderBudgetsBulkRequestOrderBudgetTransfer);
        }

        return $restOrderBudgetsBulkRequestTransfer;
    }
}
