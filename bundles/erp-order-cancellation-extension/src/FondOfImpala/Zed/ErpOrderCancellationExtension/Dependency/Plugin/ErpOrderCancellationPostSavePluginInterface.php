<?php

namespace FondOfImpala\Zed\ErpOrderCancellationExtension\Dependency\Plugin;

use Generated\Shared\Transfer\ErpOrderCancellationTransfer;

interface ErpOrderCancellationPostSavePluginInterface
{
    /**
     * Specification:
     * - Plugin is triggered after erp order cancellation object was saved.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ErpOrderCancellationTransfer $erpOrderCancellationTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationTransfer
     */
    public function postSave(ErpOrderCancellationTransfer $erpOrderCancellationTransfer): ErpOrderCancellationTransfer;
}
