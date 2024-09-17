<?php

namespace FondOfImpala\Zed\ErpOrderCancellation\Business\Model\Reader;

use Generated\Shared\Transfer\ErpOrderCancellationTransfer;

interface ReaderInterface
{
    /**
     * @param int $idErpOrderCancellation
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationTransfer|null
     */
    public function findErpOrderCancellationByIdErpOrderCancellation(int $idErpOrderCancellation): ?ErpOrderCancellationTransfer;
}
