<?php

namespace FondOfImpala\Client\PriceList;

use Generated\Shared\Transfer\PriceListListTransfer;

interface PriceListClientInterface
{
    /**
     * Specification:
     * - Finds price lists by criteria from PriceListListTransfer.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PriceListListTransfer $priceListListTransfer
     *
     * @return \Generated\Shared\Transfer\PriceListListTransfer
     */
    public function findPriceLists(
        PriceListListTransfer $priceListListTransfer
    ): PriceListListTransfer;
}
