<?php

namespace FondOfImpala\Zed\PriceProductPriceList\Dependency\Facade;

use Generated\Shared\Transfer\PriceProductTransfer;

interface PriceProductPriceListToPriceProductFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\PriceProductTransfer $priceProductTransfer
     *
     * @return \Generated\Shared\Transfer\PriceProductTransfer
     */
    public function persistPriceProductStore(PriceProductTransfer $priceProductTransfer): PriceProductTransfer;
}
