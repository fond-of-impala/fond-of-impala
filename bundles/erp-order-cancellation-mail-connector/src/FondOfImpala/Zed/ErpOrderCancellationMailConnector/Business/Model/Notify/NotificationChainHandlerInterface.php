<?php

namespace FondOfImpala\Zed\ErpOrderCancellationMailConnector\Business\Model\Notify;

use Generated\Shared\Transfer\ErpOrderCancellationTransfer;

interface NotificationChainHandlerInterface
{
    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationTransfer $erpOrderCancellationTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationTransfer
     */
    public function handleNotificationChain(ErpOrderCancellationTransfer $erpOrderCancellationTransfer): ErpOrderCancellationTransfer;
}
