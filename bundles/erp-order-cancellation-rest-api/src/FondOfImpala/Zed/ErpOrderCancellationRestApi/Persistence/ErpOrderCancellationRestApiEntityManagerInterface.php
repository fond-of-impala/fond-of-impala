<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Persistence;

use Generated\Shared\Transfer\ErpOrderCancellationTransfer;

/**
 * @method \FondOfImpala\Zed\ErpOrderCancellationRestApi\Persistence\ErpOrderCancellationRestApiPersistenceFactory getFactory()
 */
interface ErpOrderCancellationRestApiEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\ErpOrderCancellationTransfer $erpOrderCancellationTransfer
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationTransfer
     */
    public function updateErpOrderCancellationAmount(ErpOrderCancellationTransfer $erpOrderCancellationTransfer): ErpOrderCancellationTransfer;
}
