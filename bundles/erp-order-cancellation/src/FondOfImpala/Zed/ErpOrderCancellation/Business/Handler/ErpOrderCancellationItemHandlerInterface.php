<?php

namespace FondOfImpala\Zed\ErpOrderCancellation\Business\Handler;

use Generated\Shared\Transfer\ErpOrderCancellationTransfer;

interface ErpOrderCancellationItemHandlerInterface
{
    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationTransfer $erpOrderCancellationTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationTransfer
     */
    public function handle(ErpOrderCancellationTransfer $erpOrderCancellationTransfer): ErpOrderCancellationTransfer;
}
