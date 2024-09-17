<?php

namespace FondOfImpala\Zed\ErpOrderCancellation\Persistence\Propel\Mapper;

use Generated\Shared\Transfer\ErpOrderCancellationItemTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationTransfer;
use Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellation;
use Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellationItem;

interface EntityToTransferMapperInterface
{
    /**
     * @param \Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellationItem $orderItem
     * @param \Generated\Shared\Transfer\ErpOrderCancellationItemTransfer|null $orderItemTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationItemTransfer
     */
    public function fromEprOrderCancellationItemToTransfer(
        FoiErpOrderCancellationItem $orderItem,
        ?ErpOrderCancellationItemTransfer $orderItemTransfer = null
    ): ErpOrderCancellationItemTransfer;

    /**
     * @param \Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellation $erpOrderCancellation
     * @param \Generated\Shared\Transfer\ErpOrderCancellationTransfer|null $erpOrderCancellationTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationTransfer
     */
    public function fromErpOrderCancellationToTransfer(
        FoiErpOrderCancellation $erpOrderCancellation,
        ?ErpOrderCancellationTransfer $erpOrderCancellationTransfer = null
    ): ErpOrderCancellationTransfer;
}
