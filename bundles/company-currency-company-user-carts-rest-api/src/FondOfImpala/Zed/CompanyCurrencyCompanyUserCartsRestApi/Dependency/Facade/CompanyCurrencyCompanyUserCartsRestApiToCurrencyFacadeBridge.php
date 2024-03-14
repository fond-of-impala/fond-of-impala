<?php

namespace FondOfImpala\Zed\CompanyCurrencyCompanyUserCartsRestApi\Dependency\Facade;

use Generated\Shared\Transfer\StoreWithCurrencyTransfer;
use Spryker\Zed\Currency\Business\CurrencyFacadeInterface;

class CompanyCurrencyCompanyUserCartsRestApiToCurrencyFacadeBridge implements CompanyCurrencyCompanyUserCartsRestApiToCurrencyFacadeInterface
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
}
