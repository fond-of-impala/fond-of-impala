<?php

namespace FondOfImpala\Zed\ErpOrderCancellation\Business\Model\Writer;

use Generated\Shared\Transfer\ErpOrderCancellationItemTransfer;

interface ErpOrderCancellationItemWriterInterface
{
    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationItemTransfer $erpOrderCancellationItemTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationItemTransfer
     */
    public function create(ErpOrderCancellationItemTransfer $erpOrderCancellationItemTransfer): ErpOrderCancellationItemTransfer;

    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationItemTransfer $erpOrderCancellationItemTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationItemTransfer
     */
    public function update(ErpOrderCancellationItemTransfer $erpOrderCancellationItemTransfer): ErpOrderCancellationItemTransfer;

    /**
     * @param int $fkErpOrderCancellation
     * @param string $sku
     *
     * @return void
     */
    public function delete(int $fkErpOrderCancellation, string $sku): void;
}
