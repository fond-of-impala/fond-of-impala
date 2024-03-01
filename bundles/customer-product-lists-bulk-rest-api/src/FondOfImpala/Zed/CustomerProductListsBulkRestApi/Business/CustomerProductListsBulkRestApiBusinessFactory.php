<?php

namespace FondOfImpala\Zed\CustomerProductListsBulkRestApi\Business;

use FondOfImpala\Zed\CustomerProductListsBulkRestApi\Business\Expander\RestProductListsBulkRequestExpander;
use FondOfImpala\Zed\CustomerProductListsBulkRestApi\Business\Expander\RestProductListsBulkRequestExpanderInterface;
use FondOfImpala\Zed\CustomerProductListsBulkRestApi\Business\Filter\GroupedIdentifierFilter;
use FondOfImpala\Zed\CustomerProductListsBulkRestApi\Business\Filter\GroupedIdentifierFilterInterface;
use FondOfImpala\Zed\CustomerProductListsBulkRestApi\Business\Filter\ProductListIdsFilter;
use FondOfImpala\Zed\CustomerProductListsBulkRestApi\Business\Mapper\CustomerProductListRelationMapper;
use FondOfImpala\Zed\CustomerProductListsBulkRestApi\Business\Mapper\CustomerProductListRelationMapperInterface;
use FondOfImpala\Zed\CustomerProductListsBulkRestApi\Business\Persister\CustomerProductListRelationPersister;
use FondOfImpala\Zed\CustomerProductListsBulkRestApi\Business\Persister\CustomerProductListRelationPersisterInterface;
use FondOfImpala\Zed\CustomerProductListsBulkRestApi\Business\Reader\CustomerReader;
use FondOfImpala\Zed\CustomerProductListsBulkRestApi\Business\Reader\CustomerReaderInterface;
use FondOfImpala\Zed\CustomerProductListsBulkRestApi\Business\Reader\ProductListReader;
use FondOfImpala\Zed\CustomerProductListsBulkRestApi\Business\Reader\ProductListReaderInterface;
use FondOfImpala\Zed\CustomerProductListsBulkRestApi\CustomerProductListsBulkRestApiDependencyProvider;
use FondOfImpala\Zed\CustomerProductListsBulkRestApi\Dependency\Facade\CustomerProductListsBulkRestApiToCustomerProductListConnectorFacadeInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfImpala\Zed\CustomerProductListsBulkRestApi\Persistence\CustomerProductListsBulkRestApiRepositoryInterface getRepository()
 */
class CustomerProductListsBulkRestApiBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfImpala\Zed\CustomerProductListsBulkRestApi\Business\Persister\CustomerProductListRelationPersisterInterface
     */
    public function createCustomerProductListRelationPersister(): CustomerProductListRelationPersisterInterface
    {
        return new CustomerProductListRelationPersister(
            $this->createCustomerProductListRelationMapper(),
            $this->getCustomerProductListConnectorFacade(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CustomerProductListsBulkRestApi\Business\Expander\RestProductListsBulkRequestExpanderInterface
     */
    public function createRestProductListsBulkRequestExpander(): RestProductListsBulkRequestExpanderInterface
    {
        return new RestProductListsBulkRequestExpander(
            $this->createGroupedIdentifierFilter(),
            $this->createCustomerReader(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CustomerProductListsBulkRestApi\Business\Mapper\CustomerProductListRelationMapperInterface
     */
    protected function createCustomerProductListRelationMapper(): CustomerProductListRelationMapperInterface
    {
        return new CustomerProductListRelationMapper(
            $this->createProductListIdsFilter(),
            $this->createProductListReader(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CustomerProductListsBulkRestApi\Business\Filter\ProductListIdsFilter
     */
    protected function createProductListIdsFilter(): ProductListIdsFilter
    {
        return new ProductListIdsFilter();
    }

    /**
     * @return \FondOfImpala\Zed\CustomerProductListsBulkRestApi\Business\Reader\ProductListReaderInterface
     */
    protected function createProductListReader(): ProductListReaderInterface
    {
        return new ProductListReader(
            $this->getCustomerProductListConnectorFacade(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CustomerProductListsBulkRestApi\Business\Filter\GroupedIdentifierFilterInterface
     */
    protected function createGroupedIdentifierFilter(): GroupedIdentifierFilterInterface
    {
        return new GroupedIdentifierFilter();
    }

    /**
     * @return \FondOfImpala\Zed\CustomerProductListsBulkRestApi\Business\Reader\CustomerReaderInterface
     */
    protected function createCustomerReader(): CustomerReaderInterface
    {
        return new CustomerReader($this->getRepository());
    }

    /**
     * @return \FondOfImpala\Zed\CustomerProductListsBulkRestApi\Dependency\Facade\CustomerProductListsBulkRestApiToCustomerProductListConnectorFacadeInterface
     */
    protected function getCustomerProductListConnectorFacade(): CustomerProductListsBulkRestApiToCustomerProductListConnectorFacadeInterface
    {
        return $this->getProvidedDependency(
            CustomerProductListsBulkRestApiDependencyProvider::FACADE_CUSTOMER_PRODUCT_LIST_CONNECTOR,
        );
    }
}
