<?php

namespace FondOfImpala\Zed\ErpOrderCancellationExtension\Dependency\Plugin\Persistence;

use Generated\Shared\Transfer\ErpOrderCancellationTransfer;
use Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellation;

interface ErpOrderCancellationTransferExpanderPluginInterface
{
    /**
     * @param \Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellation $erpOrderCancellation
     * @param \Generated\Shared\Transfer\ErpOrderCancellationTransfer $erpOrderCancellationTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationTransfer
     */
    public function expand(
        FoiErpOrderCancellation      $erpOrderCancellation,
        ErpOrderCancellationTransfer $erpOrderCancellationTransfer
    ): ErpOrderCancellationTransfer;
}
