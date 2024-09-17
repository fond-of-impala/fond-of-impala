<?php

namespace FondOfImpala\Zed\ErpOrderCancellation\Business\PluginExecutor;

use Generated\Shared\Transfer\ErpOrderCancellationItemTransfer;

interface ErpOrderCancellationItemPluginExecutorInterface
{
    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationItemTransfer $erpOrderCancellationItemTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationItemTransfer
     */
    public function executePostSavePlugins(ErpOrderCancellationItemTransfer $erpOrderCancellationItemTransfer): ErpOrderCancellationItemTransfer;

    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationItemTransfer $erpOrderCancellationItemTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationItemTransfer
     */
    public function executePreSavePlugins(ErpOrderCancellationItemTransfer $erpOrderCancellationItemTransfer): ErpOrderCancellationItemTransfer;
}
