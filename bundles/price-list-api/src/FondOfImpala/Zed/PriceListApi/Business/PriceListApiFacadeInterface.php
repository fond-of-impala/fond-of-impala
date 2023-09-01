<?php

namespace FondOfImpala\Zed\PriceListApi\Business;

use Generated\Shared\Transfer\ApiCollectionTransfer;
use Generated\Shared\Transfer\ApiDataTransfer;
use Generated\Shared\Transfer\ApiItemTransfer;
use Generated\Shared\Transfer\ApiRequestTransfer;

interface PriceListApiFacadeInterface
{
    /**
     * Specification:
     * - Add new price list.
     * - Persist prices per added price list.
     *
     * @param \Generated\Shared\Transfer\ApiDataTransfer $apiDataTransfer
     *
     * @return \Generated\Shared\Transfer\ApiItemTransfer
     */
    public function addPriceList(ApiDataTransfer $apiDataTransfer): ApiItemTransfer;

    /**
     * Specification:
     * - Finds price list by id.
     * - Throws PriceListNotFoundException if not found.
     * - Update price list data.
     * - Persist prices per updated price list.
     *
     * @param int $id
     * @param \Generated\Shared\Transfer\ApiDataTransfer $apiDataTransfer
     *
     * @return \Generated\Shared\Transfer\ApiItemTransfer
     */
    public function updatePriceList(int $id, ApiDataTransfer $apiDataTransfer): ApiItemTransfer;

    /**
     * Specification:
     * - Hydrate price products with product ids (sku is required)
     *
     * @param array<\Generated\Shared\Transfer\PriceProductTransfer> $priceProductTransfer
     *
     * @return array<\Generated\Shared\Transfer\PriceProductTransfer>
     */
    public function hydratePriceProductsWithProductIds(array $priceProductTransfer): array;

    /**
     * Specification:
     * - Validate api data.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ApiRequestTransfer $apiRequestTransfer
     *
     * @return array<\Generated\Shared\Transfer\ApiValidationErrorTransfer>
     */
    public function validate(ApiRequestTransfer $apiRequestTransfer): array;

    /**
     * Specification:
     *  - Finds price list by price list ID.
     *  - Throws PriceListNotFoundException if not found.
     *
     * @api
     *
     * @param int $idPriceList
     *
     * @return \Generated\Shared\Transfer\ApiItemTransfer
     */
    public function getPriceList(int $idPriceList): ApiItemTransfer;

    /**
     * Specification:
     *  - Finds price lists by filter transfer, including sort, conditions and pagination.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ApiRequestTransfer $apiRequestTransfer
     *
     * @return \Generated\Shared\Transfer\ApiCollectionTransfer
     */
    public function findPriceLists(ApiRequestTransfer $apiRequestTransfer): ApiCollectionTransfer;
}
