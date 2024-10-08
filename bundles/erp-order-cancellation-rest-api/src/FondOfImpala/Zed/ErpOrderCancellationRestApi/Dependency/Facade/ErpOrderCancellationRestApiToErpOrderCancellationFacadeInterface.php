<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Dependency\Facade;

use Generated\Shared\Transfer\ErpOrderCancellationResponseTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationTransfer;

interface ErpOrderCancellationRestApiToErpOrderCancellationFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationTransfer $erpOrderCancellationTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationResponseTransfer
     */
    public function createErpOrderCancellation(ErpOrderCancellationTransfer $erpOrderCancellationTransfer): ErpOrderCancellationResponseTransfer;

    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationTransfer $erpOrderCancellationTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationResponseTransfer
     */
    public function updateErpOrderCancellation(ErpOrderCancellationTransfer $erpOrderCancellationTransfer): ErpOrderCancellationResponseTransfer;

    /**
     * @param int $idErpOrderCancellation
     *
     * @return void
     */
    public function deleteErpOrderCancellationByIdErpOrderCancellation(int $idErpOrderCancellation): void;
}
