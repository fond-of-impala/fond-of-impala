<?php

namespace FondOfImpala\Client\PriceProductPriceListSearchRestApiCompanyCurrencyConnector;

use Generated\Shared\Transfer\CurrencyTransfer;

interface PriceProductPriceListSearchRestApiCompanyCurrencyConnectorClientInterface
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
