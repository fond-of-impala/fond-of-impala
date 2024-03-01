<?php

namespace FondOfImpala\Zed\CompanyUserCartsRestApi\Communication\Plugin;

use Exception;
use FondOfImpala\Zed\CompanyUserCartsRestApiExtension\Dependency\Plugin\QuoteCreateExpanderPluginInterface;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CurrencyTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\CompanyUserCartsRestApi\Communication\CompanyUserCartsRestApiCommunicationFactory getFactory()
 */
class CompanyCurrencyToQuoteExpanderPlugin extends AbstractPlugin implements QuoteCreateExpanderPluginInterface
{
    public const COMPANY_CURRENCY_NOT_CONFIGURED = 'quote.error.company.currency.not.yet.supported';

    public function expand(QuoteTransfer $quoteTransfer, RestCompanyUserCartsRequestTransfer $restCompanyUserCartsRequestTransfer): QuoteTransfer
    {
        $currency = $this->getCompanyCurrency($quoteTransfer->getCompanyUser()->getCompany());

        if ($currency === null){
            throw new Exception(static::COMPANY_CURRENCY_NOT_CONFIGURED, static::ERROR_CODE);
        }

        return $quoteTransfer->setCurrency($currency);
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     * @return \Generated\Shared\Transfer\CurrencyTransfer|null
     * @throws \Spryker\Zed\Currency\Business\Model\Exception\CurrencyNotFoundException
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    protected function getCompanyCurrency(CompanyTransfer $companyTransfer): ?CurrencyTransfer
    {
        $currentStoreWithCurrencies = $this->getFactory()->getCurrencyFacade()->getCurrentStoreWithCurrencies();

        foreach ($currentStoreWithCurrencies->getCurrencies() as $currency) {
            if ($currency->getIdCurrency() === $companyTransfer->getFkCurrency()) {
                return $currency;
            }
        }

        return null;
    }

}
