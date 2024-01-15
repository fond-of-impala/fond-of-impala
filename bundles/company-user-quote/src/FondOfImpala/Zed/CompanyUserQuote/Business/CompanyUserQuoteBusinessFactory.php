<?php

declare(strict_types = 1);

namespace FondOfImpala\Zed\CompanyUserQuote\Business;

use FondOfImpala\Zed\CompanyUserQuote\Business\Model\CompanyUserQuoteExpander;
use FondOfImpala\Zed\CompanyUserQuote\Business\Model\CompanyUserQuoteExpanderInterface;
use FondOfImpala\Zed\CompanyUserQuote\Business\Model\CompanyUserQuoteReader;
use FondOfImpala\Zed\CompanyUserQuote\Business\Model\CompanyUserQuoteReaderInterface;
use FondOfImpala\Zed\CompanyUserQuote\CompanyUserQuoteDependencyProvider;
use FondOfImpala\Zed\CompanyUserQuote\Dependency\Facade\CompanyUserQuoteToCompanyUserReferenceFacadeInterface;
use Spryker\Zed\Quote\Business\QuoteBusinessFactory;

/**
 * @method \FondOfImpala\Zed\CompanyUserQuote\Persistence\CompanyUserQuoteEntityManagerInterface getEntityManager()
 * @method \FondOfImpala\Zed\CompanyUserQuote\Persistence\CompanyUserQuoteRepositoryInterface getRepository()
 * @method \FondOfImpala\Zed\CompanyUserQuote\CompanyUserQuoteConfig getConfig()
 */
class CompanyUserQuoteBusinessFactory extends QuoteBusinessFactory
{
    /**
     * @return \FondOfImpala\Zed\CompanyUserQuote\Business\Model\CompanyUserQuoteReaderInterface
     */
    public function createCompanyUserQuoteReader(): CompanyUserQuoteReaderInterface
    {
        return new CompanyUserQuoteReader($this->getRepository(), $this->getQuoteExpanderPlugins(), $this->getStoreFacade());
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUserQuote\Business\Model\CompanyUserQuoteExpanderInterface
     */
    public function createCompanyUserQuoteExpander(): CompanyUserQuoteExpanderInterface
    {
        return new CompanyUserQuoteExpander($this->getCompanyUserReferenceFacade());
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUserQuote\Dependency\Facade\CompanyUserQuoteToCompanyUserReferenceFacadeInterface
     */
    protected function getCompanyUserReferenceFacade(): CompanyUserQuoteToCompanyUserReferenceFacadeInterface
    {
        return $this->getProvidedDependency(CompanyUserQuoteDependencyProvider::FACADE_COMPANY_USER_REFERENCE);
    }
}
