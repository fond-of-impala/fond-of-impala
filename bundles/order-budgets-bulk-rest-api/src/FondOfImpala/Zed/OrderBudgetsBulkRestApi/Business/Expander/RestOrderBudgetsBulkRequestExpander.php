<?php

namespace FondOfImpala\Zed\OrderBudgetsBulkRestApi\Business\Expander;

use ArrayObject;
use FondOfImpala\Zed\OrderBudgetsBulkRestApi\Business\Filter\UuidsFilterInterface;
use FondOfImpala\Zed\OrderBudgetsBulkRestApi\Business\Reader\OrderBudgetReaderInterface;
use Generated\Shared\Transfer\RestOrderBudgetsBulkRequestTransfer;

class RestOrderBudgetsBulkRequestExpander implements RestOrderBudgetsBulkRequestExpanderInterface
{
    protected UuidsFilterInterface $uuidsFilter;

    protected OrderBudgetReaderInterface $orderBudgetReader;

    /**
     * @param \FondOfImpala\Zed\OrderBudgetsBulkRestApi\Business\Filter\UuidsFilterInterface $uuidsFilter
     * @param \FondOfImpala\Zed\OrderBudgetsBulkRestApi\Business\Reader\OrderBudgetReaderInterface $orderBudgetReader
     */
    public function __construct(
        UuidsFilterInterface $uuidsFilter,
        OrderBudgetReaderInterface $orderBudgetReader
    ) {
        $this->uuidsFilter = $uuidsFilter;
        $this->orderBudgetReader = $orderBudgetReader;
    }

    /**
     * @param \Generated\Shared\Transfer\RestOrderBudgetsBulkRequestTransfer $restOrderBudgetsBulkRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestOrderBudgetsBulkRequestTransfer
     */
    public function expand(
        RestOrderBudgetsBulkRequestTransfer $restOrderBudgetsBulkRequestTransfer
    ): RestOrderBudgetsBulkRequestTransfer {
        $uuids = $this->uuidsFilter->filterFromRestOrderBudgetsBulkRequest(
            $restOrderBudgetsBulkRequestTransfer,
        );

        $orderBudgetIds = $this->orderBudgetReader->getIdsByUuids($uuids);

        $restOrderBudgetsBulkRequestOrderBudgetTransfers = $this->expandRestOrderBudgetsBulkRequestOrderBudgets(
            $restOrderBudgetsBulkRequestTransfer->getOrderBudgets(),
            $orderBudgetIds,
        );

        return $restOrderBudgetsBulkRequestTransfer->setOrderBudgets($restOrderBudgetsBulkRequestOrderBudgetTransfers);
    }

    /**
     * @param \ArrayObject<\Generated\Shared\Transfer\RestOrderBudgetsBulkRequestOrderBudgetTransfer> $restOrderBudgetsBulkRequestOrderBudgetTransfers
     * @param array<string, int> $orderBudgetIds
     *
     * @return \ArrayObject<\Generated\Shared\Transfer\RestOrderBudgetsBulkRequestOrderBudgetTransfer>
     */
    protected function expandRestOrderBudgetsBulkRequestOrderBudgets(
        ArrayObject $restOrderBudgetsBulkRequestOrderBudgetTransfers,
        array $orderBudgetIds
    ): ArrayObject {
        foreach ($restOrderBudgetsBulkRequestOrderBudgetTransfers as $restOrderBudgetsBulkRequestOrderBudgetTransfer) {
            $uuid = $restOrderBudgetsBulkRequestOrderBudgetTransfer->getUuid();

            if ($uuid === null) {
                continue;
            }

            if (!isset($orderBudgetIds[$uuid])) {
                continue;
            }

            $restOrderBudgetsBulkRequestOrderBudgetTransfer->setId($orderBudgetIds[$uuid]);
        }

        return $restOrderBudgetsBulkRequestOrderBudgetTransfers;
    }
}
