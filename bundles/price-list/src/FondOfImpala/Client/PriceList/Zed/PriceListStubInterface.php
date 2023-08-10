<?php

namespace FondOfImpala\Client\PriceList\Zed;

use Generated\Shared\Transfer\PriceListListTransfer;

interface PriceListStubInterface
{
    /**
     * @param \Generated\Shared\Transfer\PriceListListTransfer $priceListListTransfer
     *
     * @return \Generated\Shared\Transfer\PriceListListTransfer
     */
    public function findPriceLists(
        PriceListListTransfer $priceListListTransfer
    ): PriceListListTransfer;
}
