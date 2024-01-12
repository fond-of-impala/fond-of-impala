<?php

namespace FondOfImpala\Zed\AllowedProductQuantity\Persistence;

use Generated\Shared\Transfer\AllowedProductQuantityTransfer;

interface AllowedProductQuantityRepositoryInterface
{
    /**
     * @param int $idProductAbstract
     *
     * @return \Generated\Shared\Transfer\AllowedProductQuantityTransfer|null
     */
    public function findAllowedProductQuantityByIdProductAbstract(int $idProductAbstract): ?AllowedProductQuantityTransfer;

    /**
     * @param array<string> $abstractSkus
     *
     * @return array<string, \Generated\Shared\Transfer\AllowedProductQuantityTransfer>
     */
    public function findGroupedAllowedProductQuantitiesByAbstractSkus(array $abstractSkus): array;
}
