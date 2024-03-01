<?php

namespace FondOfImpala\Zed\CompanyUserCartsRestApi\Business;

use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Adder\ItemAdder;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Adder\ItemAdderInterface;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Categorizer\ItemsCategorizer;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Categorizer\ItemsCategorizerInterface;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Checker\ReadPermissionChecker;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Checker\ReadPermissionCheckerInterface;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Checker\WritePermissionChecker;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Checker\WritePermissionCheckerInterface;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Creator\QuoteCreator;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Creator\QuoteCreatorInterface;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Deleter\QuoteDeleter;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Deleter\QuoteDeleterInterface;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Expander\QuoteCreateExpander;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Expander\QuoteCreateExpanderInterface;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Expander\QuoteExpander;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Expander\QuoteExpanderInterface;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Finder\ItemFinder;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Finder\ItemFinderInterface;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Finder\QuoteFinder;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Finder\QuoteFinderInterface;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Grouper\ItemsGrouper;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Grouper\ItemsGrouperInterface;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Handler\QuoteHandler;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Handler\QuoteHandlerInterface;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Mapper\ItemMapper;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Mapper\ItemMapperInterface;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Mapper\QuoteMapper;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Mapper\QuoteMapperInterface;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Reader\CompanyUserReader;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Reader\CompanyUserReaderInterface;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Reader\QuoteReader;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Reader\QuoteReaderInterface;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Remover\ItemRemover;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Remover\ItemRemoverInterface;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Updater\QuoteUpdater;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Updater\QuoteUpdaterInterface;
use FondOfImpala\Zed\CompanyUserCartsRestApi\CompanyUserCartsRestApiDependencyProvider;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Dependency\Facade\CompanyUserCartsRestApiToCartFacadeInterface;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Dependency\Facade\CompanyUserCartsRestApiToCompanyUserReferenceFacadeInterface;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Dependency\Facade\CompanyUserCartsRestApiToPermissionFacadeInterface;
use FondOfImpala\Zed\CompanyUserCartsRestApi\Dependency\Facade\CompanyUserCartsRestApiToQuoteFacadeInterface;
use Spryker\Shared\Log\LoggerTrait;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfImpala\Zed\CompanyUserCartsRestApi\CompanyUserCartsRestApiConfig getConfig()
 */
class CompanyUserCartsRestApiBusinessFactory extends AbstractBusinessFactory
{
    use LoggerTrait;

    /**
     * @return \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Creator\QuoteCreatorInterface
     */
    public function createQuoteCreator(): QuoteCreatorInterface
    {
        return new QuoteCreator(
            $this->createCompanyUserReader(),
            $this->createQuoteMapper(),
            $this->createQuoteHandler(),
            $this->createQuoteFinder(),
            $this->createWritePermissionChecker(),
            $this->getQuoteFacade(),
            $this->createQuoteCreateExpander(),
            $this->getLogger(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Updater\QuoteUpdaterInterface
     */
    public function createQuoteUpdater(): QuoteUpdaterInterface
    {
        return new QuoteUpdater(
            $this->createQuoteFinder(),
            $this->createQuoteExpander(),
            $this->createQuoteHandler(),
            $this->createWritePermissionChecker(),
            $this->getQuoteFacade(),
            $this->getLogger(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Deleter\QuoteDeleterInterface
     */
    public function createQuoteDeleter(): QuoteDeleterInterface
    {
        return new QuoteDeleter(
            $this->createQuoteReader(),
            $this->createQuoteExpander(),
            $this->createWritePermissionChecker(),
            $this->getQuoteFacade(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Finder\QuoteFinderInterface
     */
    public function createQuoteFinder(): QuoteFinderInterface
    {
        return new QuoteFinder(
            $this->createQuoteReader(),
            $this->createReadPermissionChecker(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Reader\QuoteReaderInterface
     */
    protected function createQuoteReader(): QuoteReaderInterface
    {
        return new QuoteReader(
            $this->getQuoteFacade(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Mapper\QuoteMapperInterface
     */
    protected function createQuoteMapper(): QuoteMapperInterface
    {
        return new QuoteMapper();
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Expander\QuoteExpanderInterface
     */
    protected function createQuoteExpander(): QuoteExpanderInterface
    {
        return new QuoteExpander(
            $this->getConfig(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Expander\QuoteCreateExpanderInterface
     */
    protected function createQuoteCreateExpander(): QuoteCreateExpanderInterface
    {
        return new QuoteCreateExpander(
            $this->getQuoteCreateExpanderPlugins(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Handler\QuoteHandlerInterface
     */
    protected function createQuoteHandler(): QuoteHandlerInterface
    {
        return new QuoteHandler(
            $this->createItemsCategorizer(),
            $this->createItemAdder(),
            $this->createItemRemover(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Categorizer\ItemsCategorizerInterface
     */
    protected function createItemsCategorizer(): ItemsCategorizerInterface
    {
        return new ItemsCategorizer(
            $this->createItemMapper(),
            $this->createItemFinder(),
            $this->createItemGrouper(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Mapper\ItemMapperInterface
     */
    protected function createItemMapper(): ItemMapperInterface
    {
        return new ItemMapper();
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Finder\ItemFinderInterface
     */
    protected function createItemFinder(): ItemFinderInterface
    {
        return new ItemFinder();
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Grouper\ItemsGrouperInterface
     */
    protected function createItemGrouper(): ItemsGrouperInterface
    {
        return new ItemsGrouper();
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Adder\ItemAdderInterface
     */
    protected function createItemAdder(): ItemAdderInterface
    {
        return new ItemAdder($this->getCartFacade());
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Remover\ItemRemoverInterface
     */
    protected function createItemRemover(): ItemRemoverInterface
    {
        return new ItemRemover($this->getCartFacade());
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUserCartsRestApi\Dependency\Facade\CompanyUserCartsRestApiToQuoteFacadeInterface
     */
    protected function getQuoteFacade(): CompanyUserCartsRestApiToQuoteFacadeInterface
    {
        return $this->getProvidedDependency(CompanyUserCartsRestApiDependencyProvider::FACADE_QUOTE);
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Reader\CompanyUserReaderInterface
     */
    protected function createCompanyUserReader(): CompanyUserReaderInterface
    {
        return new CompanyUserReader($this->getCompanyUserReferenceFacade());
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Checker\WritePermissionCheckerInterface
     */
    protected function createWritePermissionChecker(): WritePermissionCheckerInterface
    {
        return new WritePermissionChecker(
            $this->createCompanyUserReader(),
            $this->getPermissionFacade(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUserCartsRestApi\Business\Checker\ReadPermissionCheckerInterface
     */
    protected function createReadPermissionChecker(): ReadPermissionCheckerInterface
    {
        return new ReadPermissionChecker(
            $this->createCompanyUserReader(),
            $this->getPermissionFacade(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUserCartsRestApi\Dependency\Facade\CompanyUserCartsRestApiToCompanyUserReferenceFacadeInterface
     */
    protected function getCompanyUserReferenceFacade(): CompanyUserCartsRestApiToCompanyUserReferenceFacadeInterface
    {
        return $this->getProvidedDependency(CompanyUserCartsRestApiDependencyProvider::FACADE_COMPANY_USER_REFERENCE);
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUserCartsRestApi\Dependency\Facade\CompanyUserCartsRestApiToCartFacadeInterface
     */
    protected function getCartFacade(): CompanyUserCartsRestApiToCartFacadeInterface
    {
        return $this->getProvidedDependency(CompanyUserCartsRestApiDependencyProvider::FACADE_CART);
    }

    /**
     * @return \FondOfImpala\Zed\CompanyUserCartsRestApi\Dependency\Facade\CompanyUserCartsRestApiToPermissionFacadeInterface
     */
    protected function getPermissionFacade(): CompanyUserCartsRestApiToPermissionFacadeInterface
    {
        return $this->getProvidedDependency(CompanyUserCartsRestApiDependencyProvider::FACADE_PERMISSION);
    }

    /**
     * @return array<\FondOfImpala\Zed\CompanyUserCartsRestApiExtension\Dependency\Plugin\QuoteCreateExpanderPluginInterface>
     */
    protected function getQuoteCreateExpanderPlugins(): array
    {
        return $this->getProvidedDependency(CompanyUserCartsRestApiDependencyProvider::PLUGIN_QUOTE_CREATE_EXPANDER);
    }
}
