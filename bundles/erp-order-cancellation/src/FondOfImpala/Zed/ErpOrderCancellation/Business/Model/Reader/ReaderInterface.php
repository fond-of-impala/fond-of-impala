<?php

namespace FondOfImpala\Zed\ErpOrderCancellation\Business\Model\Reader;

use Generated\Shared\Transfer\ErpOrderCancellationCollectionTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationCriteriaFilterTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationTransfer;

interface ReaderInterface
{
    /**
     * @param int $idErpOrderCancellation
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationTransfer|null
     */
    public function findErpOrderCancellationByIdErpOrderCancellation(int $idErpOrderCancellation): ?ErpOrderCancellationTransfer;

    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationCriteriaFilterTransfer $erpOrderCancellationCriteriaFilterTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationCollectionTransfer
     */
    public function getErpOrderCancellationCollection(
        ErpOrderCancellationCriteriaFilterTransfer $erpOrderCancellationCriteriaFilterTransfer
    ): ErpOrderCancellationCollectionTransfer;
}
