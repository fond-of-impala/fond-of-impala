<?php

namespace FondOfImpala\Zed\PriceProductPriceListGui\Dependency\Facade;

use Generated\Shared\Transfer\PriceListCollectionTransfer;

interface PriceProductPriceListGuiToPriceListFacadeInterface
{
    /**
     * @return \Generated\Shared\Transfer\PriceListCollectionTransfer
     */
    public function getPriceListCollection(): PriceListCollectionTransfer;
}
