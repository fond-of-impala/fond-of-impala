<?php

namespace FondOfImpala\Zed\ErpOrderCancellationExtension\Dependency\Plugin;

use Generated\Shared\Transfer\ErpOrderCancellationItemTransfer;

interface ErpOrderCancellationItemPostSavePluginInterface
{
    /**
     * Specification:
     * - Plugin is triggered after erp order cancellation item object was saved.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ErpOrderCancellationItemTransfer $erpOrderCancellationTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationItemTransfer
     */
    public function postSave(ErpOrderCancellationItemTransfer $erpOrderCancellationTransfer): ErpOrderCancellationItemTransfer;
}
