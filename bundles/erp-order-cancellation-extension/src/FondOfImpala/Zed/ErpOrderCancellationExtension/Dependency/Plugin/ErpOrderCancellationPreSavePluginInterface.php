<?php

namespace FondOfImpala\Zed\ErpOrderCancellationExtension\Dependency\Plugin;

use Generated\Shared\Transfer\ErpOrderCancellationTransfer;

interface ErpOrderCancellationPreSavePluginInterface
{
    /**
     * Specification:
     * - Plugin is triggered before erp order cancellation object is saved.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ErpOrderCancellationTransfer $erpOrderCancellationTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationTransfer
     */
    public function preSave(ErpOrderCancellationTransfer $erpOrderCancellationTransfer): ErpOrderCancellationTransfer;
}
