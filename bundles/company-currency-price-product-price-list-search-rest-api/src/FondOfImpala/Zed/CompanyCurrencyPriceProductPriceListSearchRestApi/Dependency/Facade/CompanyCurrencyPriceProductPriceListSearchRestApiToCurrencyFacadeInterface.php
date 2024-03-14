<?php

namespace FondOfImpala\Zed\CompanyCurrencyPriceProductPriceListSearchRestApi\Dependency\Facade;

use Generated\Shared\Transfer\CurrencyTransfer;

interface CompanyCurrencyPriceProductPriceListSearchRestApiToCurrencyFacadeInterface
{
    /**
     * Specification:
     *  - Reads currency from spy_currency database table.
     *
     * @api
     *
     * @param int $idCurrency
     *
     * @throws \Spryker\Zed\Currency\Business\Model\Exception\CurrencyNotFoundException
     *
     * @return \Generated\Shared\Transfer\CurrencyTransfer
     */
    public function getByIdCurrency(int $idCurrency): CurrencyTransfer;
}
