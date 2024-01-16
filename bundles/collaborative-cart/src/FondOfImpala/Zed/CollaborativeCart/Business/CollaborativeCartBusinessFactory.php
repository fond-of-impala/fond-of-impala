<?php

namespace FondOfImpala\Zed\CollaborativeCart\Business;

use FondOfImpala\Zed\CollaborativeCart\Business\Model\CartClaimer;
use FondOfImpala\Zed\CollaborativeCart\Business\Model\CartClaimerInterface;
use FondOfImpala\Zed\CollaborativeCart\Business\Model\CompanyUserReader;
use FondOfImpala\Zed\CollaborativeCart\Business\Model\CompanyUserReaderInterface;
use FondOfImpala\Zed\CollaborativeCart\Business\Model\QuoteExpander;
use FondOfImpala\Zed\CollaborativeCart\Business\Model\QuoteExpanderInterface;
use FondOfImpala\Zed\CollaborativeCart\Business\Model\QuoteReader;
use FondOfImpala\Zed\CollaborativeCart\Business\Model\QuoteReaderInterface;
use FondOfImpala\Zed\CollaborativeCart\Business\Model\QuoteWriter;
use FondOfImpala\Zed\CollaborativeCart\Business\Model\QuoteWriterInterface;
use FondOfImpala\Zed\CollaborativeCart\Business\Releaser\CartReleaser;
use FondOfImpala\Zed\CollaborativeCart\Business\Releaser\CartReleaserInterface;
use FondOfImpala\Zed\CollaborativeCart\CollaborativeCartDependencyProvider;
use FondOfImpala\Zed\CollaborativeCart\Dependency\Facade\CollaborativeCartToCompanyUserReferenceFacadeInterface;
use FondOfImpala\Zed\CollaborativeCart\Dependency\Facade\CollaborativeCartToCustomerFacadeInterface;
use FondOfImpala\Zed\CollaborativeCart\Dependency\Facade\CollaborativeCartToPermissionFacadeInterface;
use FondOfImpala\Zed\CollaborativeCart\Dependency\Facade\CollaborativeCartToQuoteFacadeInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfImpala\Zed\CollaborativeCart\CollaborativeCartConfig getConfig()
 * @method \FondOfImpala\Zed\CollaborativeCart\Persistence\CollaborativeCartRepositoryInterface getRepository()
 */
class CollaborativeCartBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfImpala\Zed\CollaborativeCart\Business\Model\QuoteExpanderInterface
     */
    public function createQuoteExpander(): QuoteExpanderInterface
    {
        return new QuoteExpander(
            $this->getCustomerFacade(),
            $this->getCompanyUserReferenceFacade(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CollaborativeCart\Business\Model\CartClaimerInterface
     */
    public function createCartClaimer(): CartClaimerInterface
    {
        return new CartClaimer(
            $this->createQuoteReader(),
            $this->createQuoteWriter(),
            $this->createCompanyUserReader(),
            $this->getPermissionFacade(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CollaborativeCart\Business\Releaser\CartReleaserInterface
     */
    public function createCartReleaser(): CartReleaserInterface
    {
        return new CartReleaser(
            $this->createQuoteReader(),
            $this->createQuoteWriter(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CollaborativeCart\Business\Model\QuoteReaderInterface
     */
    protected function createQuoteReader(): QuoteReaderInterface
    {
        return new QuoteReader($this->getQuoteFacade());
    }

    /**
     * @return \FondOfImpala\Zed\CollaborativeCart\Business\Model\QuoteWriterInterface
     */
    protected function createQuoteWriter(): QuoteWriterInterface
    {
        return new QuoteWriter($this->getQuoteFacade());
    }

    /**
     * @return \FondOfImpala\Zed\CollaborativeCart\Business\Model\CompanyUserReaderInterface
     */
    protected function createCompanyUserReader(): CompanyUserReaderInterface
    {
        return new CompanyUserReader(
            $this->getRepository(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CollaborativeCart\Dependency\Facade\CollaborativeCartToCompanyUserReferenceFacadeInterface
     */
    protected function getCompanyUserReferenceFacade(): CollaborativeCartToCompanyUserReferenceFacadeInterface
    {
        return $this->getProvidedDependency(CollaborativeCartDependencyProvider::FACADE_COMPANY_USER_REFERENCE);
    }

    /**
     * @return \FondOfImpala\Zed\CollaborativeCart\Dependency\Facade\CollaborativeCartToCustomerFacadeInterface
     */
    protected function getCustomerFacade(): CollaborativeCartToCustomerFacadeInterface
    {
        return $this->getProvidedDependency(CollaborativeCartDependencyProvider::FACADE_CUSTOMER);
    }

    /**
     * @return \FondOfImpala\Zed\CollaborativeCart\Dependency\Facade\CollaborativeCartToPermissionFacadeInterface
     */
    protected function getPermissionFacade(): CollaborativeCartToPermissionFacadeInterface
    {
        return $this->getProvidedDependency(CollaborativeCartDependencyProvider::FACADE_PERMISSION);
    }

    /**
     * @return \FondOfImpala\Zed\CollaborativeCart\Dependency\Facade\CollaborativeCartToQuoteFacadeInterface
     */
    protected function getQuoteFacade(): CollaborativeCartToQuoteFacadeInterface
    {
        return $this->getProvidedDependency(CollaborativeCartDependencyProvider::FACADE_QUOTE);
    }
}
