<?php

namespace FondOfImpala\Zed\PriceList\Persistence;

use Generated\Shared\Transfer\PriceListCollectionTransfer;
use Generated\Shared\Transfer\PriceListListTransfer;
use Generated\Shared\Transfer\PriceListTransfer;

interface PriceListRepositoryInterface
{
    /**
     * Specification:
     * - Returns a PriceListTransfer by price list id.
     * - Returns null in case a record is not found.
     *
     * @api
     *
     * @param int $idPriceList
     *
     * @return \Generated\Shared\Transfer\PriceListTransfer|null
     */
    public function getById(int $idPriceList): ?PriceListTransfer;

    /**
     * Specification:
     * - Returns a PriceListTransfer by price list name.
     * - Returns null in case a record is not found.
     *
     * @api
     *
     * @param string $name
     *
     * @return \Generated\Shared\Transfer\PriceListTransfer|null
     */
    public function getByName(string $name): ?PriceListTransfer;

    /**
     * Specification:
     * - Returns a PriceListCollectionTransfer.
     * - Returns empty collection in case no record is found.
     *
     * @api
     *
     * @return \Generated\Shared\Transfer\PriceListCollectionTransfer
     */
    public function getAll(): PriceListCollectionTransfer;

    /**
     * @param \Generated\Shared\Transfer\PriceListListTransfer $priceListListTransfer
     *
     * @return \Generated\Shared\Transfer\PriceListListTransfer
     */
    public function findPriceLists(PriceListListTransfer $priceListListTransfer): PriceListListTransfer;
}
