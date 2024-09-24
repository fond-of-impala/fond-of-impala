<?php

namespace FondOfImpala\Zed\ErpOrderCancellation\Persistence;

use Generated\Shared\Transfer\ErpOrderCancellationItemTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationTransfer;

interface ErpOrderCancellationEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationTransfer $erpOrderCancellationTransfer
     *
     * @throws \Exception
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationTransfer
     */
    public function createErpOrderCancellation(ErpOrderCancellationTransfer $erpOrderCancellationTransfer): ErpOrderCancellationTransfer;

    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationItemTransfer $itemTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationItemTransfer
     */
    public function createErpOrderCancellationItem(ErpOrderCancellationItemTransfer $itemTransfer): ErpOrderCancellationItemTransfer;

    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationTransfer $erpOrderCancellationTransfer
     *
     * @throws \Exception
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationTransfer
     */
    public function updateErpOrderCancellation(ErpOrderCancellationTransfer $erpOrderCancellationTransfer): ErpOrderCancellationTransfer;

    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationItemTransfer $orderItemTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationItemTransfer
     */
    public function updateErpOrderCancellationItem(ErpOrderCancellationItemTransfer $orderItemTransfer): ErpOrderCancellationItemTransfer;

    /**
     * @param int $idErpOrderCancellation
     *
     * @return void
     */
    public function deleteErpOrderCancellationByIdErpOrderCancellation(int $idErpOrderCancellation): void;

    /**
     * @param int $fkErpOrderCancellation
     * @param string $sku
     *
     * @return void
     */
    public function deleteErpOrderCancellationItemByIdErpOrderCancellationItem(int $fkErpOrderCancellation, string $sku): void;
}
