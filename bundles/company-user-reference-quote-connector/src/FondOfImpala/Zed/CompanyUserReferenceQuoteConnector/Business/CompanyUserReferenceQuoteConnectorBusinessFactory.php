<?php

namespace FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Business;

use FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Business\Deleter\QuoteDeleter;
use FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Business\Deleter\QuoteDeleterInterface;
use FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Business\Model\QuoteReader;
use FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Business\Model\QuoteReaderInterface;
use FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\CompanyUserReferenceQuoteConnectorDependencyProvider;
use FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Dependency\Facade\CompanyUserReferenceQuoteConnectorToQuoteFacadeInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Persistence\CompanyUserReferenceQuoteConnectorRepositoryInterface getRepository()
 */
class CompanyUserReferenceQuoteConnectorBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Business\Model\QuoteReaderInterface
     */
    public function createQuoteReader(): QuoteReaderInterface
    {
        return new QuoteReader(
            $this->getRepository(),
            $this->getQuoteFacade(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Business\Deleter\QuoteDeleterInterface
     */
    public function createQuoteDeleter(): QuoteDeleterInterface
    {
        return new QuoteDeleter(
            $this->createQuoteReader(),
            $this->getQuoteFacade(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Dependency\Facade\CompanyUserReferenceQuoteConnectorToQuoteFacadeInterface
     */
    protected function getQuoteFacade(): CompanyUserReferenceQuoteConnectorToQuoteFacadeInterface
    {
        return $this->getProvidedDependency(CompanyUserReferenceQuoteConnectorDependencyProvider::FACADE_QUOTE);
    }
}
