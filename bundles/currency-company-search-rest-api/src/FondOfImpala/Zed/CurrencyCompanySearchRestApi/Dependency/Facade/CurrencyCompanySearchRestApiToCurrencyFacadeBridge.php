<?php

namespace FondOfImpala\Zed\CurrencyCompanySearchRestApi\Dependency\Facade;

use Generated\Shared\Transfer\CurrencyTransfer;
use Spryker\Zed\Currency\Business\CurrencyFacadeInterface;

class CurrencyCompanySearchRestApiToCurrencyFacadeBridge implements CurrencyCompanySearchRestApiToCurrencyFacadeInterface
{
    protected CurrencyFacadeInterface $currencyFacade;

    /**
     * @param \Spryker\Zed\Currency\Business\CurrencyFacadeInterface $currencyFacade
     */
    public function __construct(CurrencyFacadeInterface $currencyFacade)
    {
        $this->currencyFacade = $currencyFacade;
    }

    /**
     * @param int $idCurrency
     *
     * @return \Generated\Shared\Transfer\CurrencyTransfer
     */
    public function getByIdCurrency(int $idCurrency): CurrencyTransfer
    {
        return $this->currencyFacade->getByIdCurrency($idCurrency);
    }
}
