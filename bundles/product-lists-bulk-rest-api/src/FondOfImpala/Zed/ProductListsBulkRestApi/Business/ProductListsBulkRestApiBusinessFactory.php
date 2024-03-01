<?php

namespace FondOfImpala\Zed\ProductListsBulkRestApi\Business;

use FondOfImpala\Zed\ProductListsBulkRestApi\Business\Checker\RestProductListsBulkRequestAssignmentChecker;
use FondOfImpala\Zed\ProductListsBulkRestApi\Business\Checker\RestProductListsBulkRequestAssignmentCheckerInterface;
use FondOfImpala\Zed\ProductListsBulkRestApi\Business\Expander\RestProductListsBulkRequestExpander;
use FondOfImpala\Zed\ProductListsBulkRestApi\Business\Expander\RestProductListsBulkRequestExpanderInterface;
use FondOfImpala\Zed\ProductListsBulkRestApi\Business\Filter\GroupedIdentifierFilter;
use FondOfImpala\Zed\ProductListsBulkRestApi\Business\Filter\GroupedIdentifierFilterInterface;
use FondOfImpala\Zed\ProductListsBulkRestApi\Business\Processor\BulkProcessor;
use FondOfImpala\Zed\ProductListsBulkRestApi\Business\Processor\BulkProcessorInterface;
use FondOfImpala\Zed\ProductListsBulkRestApi\Business\Reader\ProductListReader;
use FondOfImpala\Zed\ProductListsBulkRestApi\Business\Reader\ProductListReaderInterface;
use FondOfImpala\Zed\ProductListsBulkRestApi\Dependency\Facade\ProductListsBulkRestApiToEventFacadeInterface;
use FondOfImpala\Zed\ProductListsBulkRestApi\ProductListsBulkRestApiDependencyProvider;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfImpala\Zed\ProductListsBulkRestApi\Persistence\ProductListsBulkRestApiRepositoryInterface getRepository()
 */
class ProductListsBulkRestApiBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfImpala\Zed\ProductListsBulkRestApi\Business\Processor\BulkProcessorInterface
     */
    public function createBulkProcessor(): BulkProcessorInterface
    {
        return new BulkProcessor(
            $this->createRestProductListsBulkRequestAssignmentChecker(),
            $this->getEventFacade(),
            $this->getRestProductListsBulkRequestExpanderPlugins(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\ProductListsBulkRestApi\Business\Expander\RestProductListsBulkRequestExpanderInterface
     */
    public function createRestProductListsBulkRequestExpander(): RestProductListsBulkRequestExpanderInterface
    {
        return new RestProductListsBulkRequestExpander(
            $this->createGroupedIdentifierFilter(),
            $this->createProductListReader(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\ProductListsBulkRestApi\Business\Filter\GroupedIdentifierFilterInterface
     */
    protected function createGroupedIdentifierFilter(): GroupedIdentifierFilterInterface
    {
        return new GroupedIdentifierFilter();
    }

    /**
     * @return \FondOfImpala\Zed\ProductListsBulkRestApi\Business\Reader\ProductListReaderInterface
     */
    protected function createProductListReader(): ProductListReaderInterface
    {
        return new ProductListReader($this->getRepository());
    }

    /**
     * @return \FondOfImpala\Zed\ProductListsBulkRestApi\Business\Checker\RestProductListsBulkRequestAssignmentCheckerInterface
     */
    protected function createRestProductListsBulkRequestAssignmentChecker(): RestProductListsBulkRequestAssignmentCheckerInterface
    {
        return new RestProductListsBulkRequestAssignmentChecker(
            $this->getRestProductListsBulkRequestAssignmentPreCheckPlugins(),
        );
    }

    /**
     * @return array<\FondOfImpala\Zed\ProductListsBulkRestApiExtension\Dependency\Plugin\RestProductListsBulkRequestAssignmentPreCheckPluginInterface>
     */
    protected function getRestProductListsBulkRequestAssignmentPreCheckPlugins(): array
    {
        return $this->getProvidedDependency(
            ProductListsBulkRestApiDependencyProvider::PLUGINS_REST_PRODUCT_LISTS_BULK_REQUEST_ASSIGNMENT_PRE_CHECK,
        );
    }

    /**
     * @return array<\FondOfImpala\Zed\ProductListsBulkRestApiExtension\Dependency\Plugin\RestProductListsBulkRequestExpanderPluginInterface>
     */
    protected function getRestProductListsBulkRequestExpanderPlugins(): array
    {
        return $this->getProvidedDependency(
            ProductListsBulkRestApiDependencyProvider::PLUGINS_REST_PRODUCT_LISTS_BULK_REQUEST_EXPANDER,
        );
    }

    /**
     * @return \FondOfImpala\Zed\ProductListsBulkRestApi\Dependency\Facade\ProductListsBulkRestApiToEventFacadeInterface
     */
    protected function getEventFacade(): ProductListsBulkRestApiToEventFacadeInterface
    {
        return $this->getProvidedDependency(
            ProductListsBulkRestApiDependencyProvider::FACADE_EVENT,
        );
    }
}
