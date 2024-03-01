<?php

namespace FondOfImpala\Zed\CompanyUserCartsRestApi\Dependency\Facade;

use Generated\Shared\Transfer\CurrencyTransfer;
use Generated\Shared\Transfer\StoreWithCurrencyTransfer;

interface CompanyUserCartsRestApiToCurrencyFacadeInterface
{
    /**
     * Specification:
     * - Returns CurrencyTransfer object for current ISO code.
     *
     * @api
     *
     * @return \Generated\Shared\Transfer\CurrencyTransfer
     */
    public function getCurrent(): CurrencyTransfer;

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

    /**
     * Specification:
     *  - Reads all active store currencies
     *
     * @api
     *
     * @throws \Spryker\Zed\Currency\Business\Model\Exception\CurrencyNotFoundException
     *
     * @return array<\Generated\Shared\Transfer\StoreWithCurrencyTransfer>
     */
    public function getAllStoresWithCurrencies(): array;
}
