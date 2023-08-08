<?php

namespace FondOfImpala\Zed\PriceListApi\Dependency\Facade;

use Generated\Shared\Transfer\PriceProductTransfer;

interface PriceListApiToPriceProductPriceListFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\PriceProductTransfer $priceProductTransfer
     *
     * @return \Generated\Shared\Transfer\PriceProductTransfer
     */
    public function savePriceProductPriceList(PriceProductTransfer $priceProductTransfer): PriceProductTransfer;
}
