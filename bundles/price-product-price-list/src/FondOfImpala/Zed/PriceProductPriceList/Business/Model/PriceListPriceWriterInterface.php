<?php

namespace FondOfImpala\Zed\PriceProductPriceList\Business\Model;

use Generated\Shared\Transfer\PriceProductTransfer;

interface PriceListPriceWriterInterface
{
    /**
     * @param \Generated\Shared\Transfer\PriceProductTransfer $priceProductTransfer
     *
     * @return \Generated\Shared\Transfer\PriceProductTransfer
     */
    public function persist(PriceProductTransfer $priceProductTransfer): PriceProductTransfer;

    /**
     * @param int $idPriceProductStore
     *
     * @return void
     */
    public function deleteByIdPriceProductStore(int $idPriceProductStore): void;
}
