<?php

namespace FondOfImpala\Zed\ErpOrderCancellation\Business\Model\Reader;

use ArrayObject;
use Generated\Shared\Transfer\ErpOrderCancellationItemTransfer;

interface ErpOrderCancellationItemReaderInterface
{
    /**
     * @param int $fkErpOrderCancellation
     * @param string $sku
     * @return \Generated\Shared\Transfer\ErpOrderCancellationItemTransfer|null
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     */
    public function findErpOrderCancellationItemByIdErpOrderCancellationAndSku(int $fkErpOrderCancellation, string $sku): ?ErpOrderCancellationItemTransfer;

    /**
     * @param int $idErpOrderCancellation
     * @return \ArrayObject
     */
    public function findErpOrderCancellationItemsByIdErpOrderCancellation(int $idErpOrderCancellation): ArrayObject;
}
