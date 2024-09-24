<?php

namespace FondOfImpala\Zed\ErpOrderCancellationExtension\Dependency\Plugin;

use Generated\Shared\Transfer\ErpOrderCancellationItemTransfer;

interface ErpOrderCancellationItemPreSavePluginInterface
{
    /**
     * Specification:
     * - Plugin is triggered before erp order cancellation item object is saved.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ErpOrderCancellationItemTransfer $erpOrderCancellationItemTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationItemTransfer
     */
    public function preSave(ErpOrderCancellationItemTransfer $erpOrderCancellationItemTransfer): ErpOrderCancellationItemTransfer;
}
