<?php

namespace FondOfImpala\Zed\CompanyPriceList\Dependency\Facade;

use Generated\Shared\Transfer\PriceListTransfer;

interface CompanyPriceListToPriceListFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\PriceListTransfer $priceListTransfer
     *
     * @return \Generated\Shared\Transfer\PriceListTransfer|null
     */
    public function findPriceListById(PriceListTransfer $priceListTransfer): ?PriceListTransfer;
}
