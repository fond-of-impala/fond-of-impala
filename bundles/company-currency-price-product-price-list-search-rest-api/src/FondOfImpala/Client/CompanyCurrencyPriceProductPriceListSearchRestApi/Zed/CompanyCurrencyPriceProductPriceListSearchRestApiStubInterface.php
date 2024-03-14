<?php

namespace FondOfImpala\Client\CompanyCurrencyPriceProductPriceListSearchRestApi\Zed;

use Generated\Shared\Transfer\CurrencyTransfer;

interface CompanyCurrencyPriceProductPriceListSearchRestApiStubInterface
{
    /**
     * @param \Generated\Shared\Transfer\CurrencyTransfer $currencyTransfer
     *
     * @return \Generated\Shared\Transfer\CurrencyTransfer
     */
    public function getCurrencyById(CurrencyTransfer $currencyTransfer): CurrencyTransfer;
}
