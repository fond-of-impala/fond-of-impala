<?php

namespace FondOfImpala\Client\CompanyCurrencyPriceProductPriceListSearchRestApi;

use Generated\Shared\Transfer\CurrencyTransfer;

interface CompanyCurrencyPriceProductPriceListSearchRestApiClientInterface
{
    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\CurrencyTransfer $currencyTransfer
     *
     * @return \Generated\Shared\Transfer\CurrencyTransfer
     */
    public function getCurrencyById(CurrencyTransfer $currencyTransfer): CurrencyTransfer;
}
