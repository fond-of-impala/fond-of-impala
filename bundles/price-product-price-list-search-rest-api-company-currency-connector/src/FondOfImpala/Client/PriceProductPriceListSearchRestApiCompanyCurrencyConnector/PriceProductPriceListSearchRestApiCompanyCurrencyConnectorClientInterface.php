<?php

namespace FondOfImpala\Client\PriceProductPriceListSearchRestApiCompanyCurrencyConnector;

use Generated\Shared\Transfer\CurrencyTransfer;

interface PriceProductPriceListSearchRestApiCompanyCurrencyConnectorClientInterface
{
    /**
     * @param \Generated\Shared\Transfer\CurrencyTransfer $currencyTransfer
     * @return \Generated\Shared\Transfer\CurrencyTransfer
     * @api
     */
    public function getCurrencyById(CurrencyTransfer $currencyTransfer): CurrencyTransfer;
}
