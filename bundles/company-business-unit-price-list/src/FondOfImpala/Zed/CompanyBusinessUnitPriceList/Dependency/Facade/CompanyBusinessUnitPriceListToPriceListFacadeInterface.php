<?php

namespace FondOfImpala\Zed\CompanyBusinessUnitPriceList\Dependency\Facade;

use Generated\Shared\Transfer\PriceListTransfer;

interface CompanyBusinessUnitPriceListToPriceListFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\PriceListTransfer $priceListTransfer
     *
     * @return \Generated\Shared\Transfer\PriceListTransfer|null
     */
    public function findPriceListById(PriceListTransfer $priceListTransfer): ?PriceListTransfer;
}
