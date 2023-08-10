<?php

namespace FondOfImpala\Zed\PriceProductPriceList\Dependency\Facade;

use Generated\Shared\Transfer\PriceListTransfer;

interface PriceProductPriceListToPriceListFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\PriceListTransfer $priceListTransfer
     *
     * @return \Generated\Shared\Transfer\PriceListTransfer|null
     */
    public function findPriceListById(PriceListTransfer $priceListTransfer): ?PriceListTransfer;
}
