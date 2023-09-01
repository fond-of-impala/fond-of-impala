<?php

namespace FondOfImpala\Zed\PriceList\Persistence;

use Generated\Shared\Transfer\PriceListTransfer;

interface PriceListEntityManagerInterface
{
    /**
     * Specification:
     * - Create or update a price list.
     * - Finds a price list by PriceListTransfer::idPriceList.
     * - Persists the entity to DB.
     *
     * @param \Generated\Shared\Transfer\PriceListTransfer $priceListTransfer
     *
     * @return \Generated\Shared\Transfer\PriceListTransfer
     */
    public function persist(PriceListTransfer $priceListTransfer): PriceListTransfer;

    /**
     * Specification:
     * - Finds a price list by ID.
     * - Deletes the price list.
     *
     * @param int $idProductList
     *
     * @return void
     */
    public function deleteById(int $idProductList): void;

    /**
     * Specification:
     * - Finds a price list by NAME.
     * - Deletes the price list.
     *
     * @param string $name
     *
     * @return void
     */
    public function deleteByName(string $name): void;
}
