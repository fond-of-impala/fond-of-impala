<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\Model\Expander;

use Generated\Shared\Transfer\ErpOrderCancellationTransfer;
use Generated\Shared\Transfer\RestErpOrderCancellationRequestTransfer;

interface ErpOrderCancellationExpanderInterface
{
    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationTransfer $erpOrderCancellationTransfer
     * @param \Generated\Shared\Transfer\RestErpOrderCancellationRequestTransfer $restErpOrderCancellationRequestTransfer
     * @return \Generated\Shared\Transfer\ErpOrderCancellationTransfer
     */
    public function expand(ErpOrderCancellationTransfer $erpOrderCancellationTransfer, RestErpOrderCancellationRequestTransfer $restErpOrderCancellationRequestTransfer): ErpOrderCancellationTransfer;
}
