<?php

namespace FondOfImpala\Zed\CompanyPriceListGui\Dependency\Facade;

use Generated\Shared\Transfer\PriceListCollectionTransfer;

interface CompanyPriceListGuiToPriceListFacadeInterface
{
    /**
     * @return \Generated\Shared\Transfer\PriceListCollectionTransfer
     */
    public function getPriceListCollection(): PriceListCollectionTransfer;
}
