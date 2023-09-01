<?php

namespace FondOfImpala\Zed\PriceProductPriceList\Persistence;

use Generated\Shared\Transfer\FoiPriceProductPriceListEntityTransfer;
use Spryker\Shared\Kernel\Transfer\EntityTransferInterface;

interface PriceProductPriceListEntityManagerInterface
{
    /**
     * Specification:
     * - Create or update a relationship between price product and price list.
     * - Finds a relation by FoiPriceProductPriceListEntityTransfer::idPriceProductPriceList.
     * - Persists the relation entity to DB.
     *
     * @param \Generated\Shared\Transfer\FoiPriceProductPriceListEntityTransfer $priceProductPriceListEntityTransfer
     *
     * @return \Spryker\Shared\Kernel\Transfer\EntityTransferInterface
     */
    public function persistEntity(
        FoiPriceProductPriceListEntityTransfer $priceProductPriceListEntityTransfer
    ): EntityTransferInterface;

    /**
     * @param int $idPriceProductStore
     *
     * @return void
     */
    public function deleteByIdPriceProductStore(int $idPriceProductStore): void;
}
