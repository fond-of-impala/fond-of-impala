<?php

namespace FondOfImpala\Zed\CompanyCurrencyCompanyUserCartsRestApi\Communication\Plugin\CompanyUserCartsRestApi;

use Exception;
use FondOfImpala\Shared\CompanyCurrencyCompanyUserCartsRestApi\CompanyCurrencyCompanyUserCartsRestApiConstants;
use FondOfImpala\Zed\CompanyUserCartsRestApiExtension\Dependency\Plugin\QuoteCreateExpanderPluginInterface;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CurrencyTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfImpala\Zed\CompanyCurrencyCompanyUserCartsRestApi\Communication\CompanyCurrencyCompanyUserCartsRestApiCommunicationFactory getFactory()
 */
class CompanyCurrencyToQuoteExpanderPlugin extends AbstractPlugin implements QuoteCreateExpanderPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\RestCompanyUserCartsRequestTransfer $restCompanyUserCartsRequestTransfer
     *
     * @throws \Exception
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function expand(QuoteTransfer $quoteTransfer, RestCompanyUserCartsRequestTransfer $restCompanyUserCartsRequestTransfer): QuoteTransfer
    {
        $currency = $this->getCompanyCurrency($quoteTransfer->getCompanyUser()->getCompany());

        if ($currency === null) {
            throw new Exception(CompanyCurrencyCompanyUserCartsRestApiConstants::ERROR_MESSAGE_COMPANY_CURRENCY_NOT_SUPPORTED, static::ERROR_CODE);
        }

        return $quoteTransfer->setCurrency($currency);
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @return \Generated\Shared\Transfer\CurrencyTransfer|null
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
