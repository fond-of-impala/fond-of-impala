<?php

namespace FondOfImpala\Zed\ErpOrderCancellation\Business\PluginExecutor;

use Generated\Shared\Transfer\ErpOrderCancellationResponseTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationTransfer;

interface ErpOrderCancellationPluginExecutorInterface
{
    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationTransfer $erpOrderCancellationTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationTransfer
     */
    public function executePostSavePlugins(ErpOrderCancellationTransfer $erpOrderCancellationTransfer): ErpOrderCancellationTransfer;

    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationTransfer $erpOrderCancellationTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationTransfer
     */
    public function executePreSavePlugins(ErpOrderCancellationTransfer $erpOrderCancellationTransfer): ErpOrderCancellationTransfer;

    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationResponseTransfer $erpOrderCancellationResponseTransfer
     * @return \Generated\Shared\Transfer\ErpOrderCancellationResponseTransfer
     */
    public function executePostTransactionPlugins(ErpOrderCancellationResponseTransfer $erpOrderCancellationResponseTransfer): ErpOrderCancellationResponseTransfer;
}
