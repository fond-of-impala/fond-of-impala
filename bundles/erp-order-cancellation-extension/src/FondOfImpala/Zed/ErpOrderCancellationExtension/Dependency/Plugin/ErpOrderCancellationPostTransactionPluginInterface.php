<?php

namespace FondOfImpala\Zed\ErpOrderCancellationExtension\Dependency\Plugin;

use Generated\Shared\Transfer\ErpOrderCancellationResponseTransfer;

interface ErpOrderCancellationPostTransactionPluginInterface
{
    /**
     * Specification:
     * - Plugin is triggered after erp order cancellation object was completely persisted.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ErpOrderCancellationResponseTransfer $erpOrderCancellationResponseTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationResponseTransfer
     */
    public function postTransaction(ErpOrderCancellationResponseTransfer $erpOrderCancellationResponseTransfer): ErpOrderCancellationResponseTransfer;
}
