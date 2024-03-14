<?php

namespace FondOfImpala\Zed\CompanyCurrencyPriceProductPriceListSearchRestApi\Dependency\Facade;

use Generated\Shared\Transfer\CurrencyTransfer;
use Spryker\Zed\Currency\Business\CurrencyFacadeInterface;

class CompanyCurrencyPriceProductPriceListSearchRestApiToCurrencyFacadeBridge implements CompanyCurrencyPriceProductPriceListSearchRestApiToCurrencyFacadeInterface
{
    /**
     * @var \Spryker\Zed\Currency\Business\CurrencyFacadeInterface
     */
    protected CurrencyFacadeInterface $facade;

    /**
     * @param \Spryker\Zed\Currency\Business\CurrencyFacadeInterface $currencyFacade
     */
    public function __construct(CurrencyFacadeInterface $currencyFacade)
    {
        $this->facade = $currencyFacade;
    }

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
    public function getByIdCurrency(int $idCurrency): CurrencyTransfer
    {
        return $this->facade->getByIdCurrency($idCurrency);
    }
}
