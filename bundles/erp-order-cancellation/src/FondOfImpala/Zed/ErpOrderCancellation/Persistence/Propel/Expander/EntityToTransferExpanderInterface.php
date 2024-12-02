<?php

namespace FondOfImpala\Zed\ErpOrderCancellation\Persistence\Propel\Expander;

use Generated\Shared\Transfer\ErpOrderCancellationTransfer;
use Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellation;

interface EntityToTransferExpanderInterface
{
    /**
     * @param \Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellation $erpOrderCancellation
     * @param \Generated\Shared\Transfer\ErpOrderCancellationTransfer $erpOrderCancellationTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationTransfer
     */
    public function expandErpOrderCancellation(
        FoiErpOrderCancellation      $erpOrderCancellation,
        ErpOrderCancellationTransfer $erpOrderCancellationTransfer
    ): ErpOrderCancellationTransfer;
}
