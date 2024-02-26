<?php

namespace FondOfImpala\Zed\CurrencyCompanySearchRestApi\Dependency\Facade;

use Generated\Shared\Transfer\CurrencyTransfer;

interface CurrencyCompanySearchRestApiToCurrencyFacadeInterface
{
    /**
     * @param int $idCurrency
     *
     * @return \Generated\Shared\Transfer\CurrencyTransfer
     */
    public function getByIdCurrency(int $idCurrency): CurrencyTransfer;
}
