<?php

namespace FondOfImpala\Zed\AllowedProductQuantity\Persistence;

use Generated\Shared\Transfer\AllowedProductQuantityTransfer;

interface AllowedProductQuantityEntityManagerInterface
{
    /**
     * Specification:
     * - Create or update.
     * - Finds an entry by \Generated\Shared\Transfer\AllowedProductQuantityTransfer::idAllowedProductQuantity.
     * - Persists the entity to DB.
     *
     * @param \Generated\Shared\Transfer\AllowedProductQuantityTransfer $allowedProductQuantityTransfer
     *
     * @return \Generated\Shared\Transfer\AllowedProductQuantityTransfer
     */
    public function persistAllowedProductQuantity(
        AllowedProductQuantityTransfer $allowedProductQuantityTransfer
    ): AllowedProductQuantityTransfer;

    /**
     * Specification:
     * - Finds an entry by ID.
     * - Deletes the entry.
     *
     * @param int $idAllowedProductQuantity
     *
     * @return void
     */
    public function deleteAllowedProductQuantityById(int $idAllowedProductQuantity): void;
}
