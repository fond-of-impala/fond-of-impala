<?php

namespace FondOfImpala\Zed\PriceProductPriceListSearchRestApiCompanyCurrencyConnector\Dependency\Facade;

use Generated\Shared\Transfer\CurrencyTransfer;

interface PriceProductPriceListSearchRestApiCompanyCurrencyConnectorToCurrencyFacadeInterface
{
    /**
     * Specification:
     *  - Reads currency from spy_currency database table.
     *
     * @param int $idCurrency
     *
     * @return \Generated\Shared\Transfer\CurrencyTransfer
     * @throws \Spryker\Zed\Currency\Business\Model\Exception\CurrencyNotFoundException
     *
     * @api
     *
     */
    public function getByIdCurrency(int $idCurrency): CurrencyTransfer;
}
