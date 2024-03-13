<?php

namespace FondOfImpala\Zed\CompanyUserCartsRestApi\Dependency\Facade;

use Generated\Shared\Transfer\StoreWithCurrencyTransfer;

interface CompanyUserCartsRestApiToCurrencyFacadeInterface
{
    /**
     * Specification:
     *  - Reads all active currencies for current store
     *
     * @api
     *
     * @throws \Spryker\Zed\Currency\Business\Model\Exception\CurrencyNotFoundException
     *
     * @return \Generated\Shared\Transfer\StoreWithCurrencyTransfer
     */
    public function getCurrentStoreWithCurrencies(): StoreWithCurrencyTransfer;
}
