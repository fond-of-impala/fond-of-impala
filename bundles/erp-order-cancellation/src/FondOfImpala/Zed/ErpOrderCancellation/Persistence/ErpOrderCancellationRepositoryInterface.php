<?php

namespace FondOfImpala\Zed\ErpOrderCancellation\Persistence;

use ArrayObject;
use Generated\Shared\Transfer\ErpOrderCancellationItemTransfer;
use Generated\Shared\Transfer\ErpOrderCancellationTransfer;

interface ErpOrderCancellationRepositoryInterface
{
    /**
     * @param int $idErpOrderCancellation
     *
     * @return \Generated\Shared\Transfer\ErpOrderCancellationTransfer|null
     */
    public function findErpOrderCancellationByIdErpOrderCancellation(int $idErpOrderCancellation): ?ErpOrderCancellationTransfer;

    /**
     * @param int $idErpOrderCancellation
     * @return \ArrayObject
     */
    public function findErpOrderCancellationItemsByIdErpOrderCancellation(int $idErpOrderCancellation): ArrayObject;

    /**
     * @param int $fkErpOrderCancellation
     * @param string $sku
     * @return \Generated\Shared\Transfer\ErpOrderCancellationItemTransfer|null
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     */
    public function findErpOrderCancellationItemByIdErpOrderCancellationAndSku(int $fkErpOrderCancellation, string $sku): ?ErpOrderCancellationItemTransfer;
}
