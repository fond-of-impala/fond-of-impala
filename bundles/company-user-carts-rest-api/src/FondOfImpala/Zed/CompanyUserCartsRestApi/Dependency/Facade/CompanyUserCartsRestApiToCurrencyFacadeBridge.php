<?php

namespace FondOfImpala\Zed\CompanyUserCartsRestApi\Dependency\Facade;

use Generated\Shared\Transfer\CurrencyTransfer;
use Generated\Shared\Transfer\StoreWithCurrencyTransfer;
use Spryker\Zed\Currency\Business\CurrencyFacadeInterface;

class CompanyUserCartsRestApiToCurrencyFacadeBridge implements CompanyUserCartsRestApiToCurrencyFacadeInterface
{
    /**
     * @var \Spryker\Zed\Currency\Business\CurrencyFacadeInterface
     */
    protected $currencyFacade;

    /**
     * @param \Spryker\Zed\Currency\Business\CurrencyFacadeInterface $currencyFacade
     */
    public function __construct(CurrencyFacadeInterface $currencyFacade)
    {
        $this->currencyFacade = $currencyFacade;
    }

    /**
     * Specification:
     * - Returns CurrencyTransfer object for current ISO code.
     *
     * @api
     *
     * @return \Generated\Shared\Transfer\CurrencyTransfer
     */
    public function getCurrent(): CurrencyTransfer
    {
        return $this->currencyFacade->getCurrent();
    }

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
    public function getCurrentStoreWithCurrencies(): StoreWithCurrencyTransfer
    {
        return $this->currencyFacade->getCurrentStoreWithCurrencies();
    }

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
    public function getAllStoresWithCurrencies(): array
    {
        return $this->currencyFacade->getAllStoresWithCurrencies();
    }
}
