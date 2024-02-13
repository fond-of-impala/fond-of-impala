<?php

namespace FondOfImpala\Zed\CompanyProductListsBulkRestApi\Business;

use FondOfImpala\Zed\CompanyProductListsBulkRestApi\Business\Expander\RestProductListsBulkRequestExpander;
use FondOfImpala\Zed\CompanyProductListsBulkRestApi\Business\Expander\RestProductListsBulkRequestExpanderInterface;
use FondOfImpala\Zed\CompanyProductListsBulkRestApi\Business\Filter\GroupedIdentifierFilter;
use FondOfImpala\Zed\CompanyProductListsBulkRestApi\Business\Filter\GroupedIdentifierFilterInterface;
use FondOfImpala\Zed\CompanyProductListsBulkRestApi\Business\Filter\ProductListIdsFilter;
use FondOfImpala\Zed\CompanyProductListsBulkRestApi\Business\Mapper\CompanyProductListRelationMapper;
use FondOfImpala\Zed\CompanyProductListsBulkRestApi\Business\Mapper\CompanyProductListRelationMapperInterface;
use FondOfImpala\Zed\CompanyProductListsBulkRestApi\Business\Persister\CompanyProductListRelationPersister;
use FondOfImpala\Zed\CompanyProductListsBulkRestApi\Business\Persister\CompanyProductListRelationPersisterInterface;
use FondOfImpala\Zed\CompanyProductListsBulkRestApi\Business\Reader\CompanyReader;
use FondOfImpala\Zed\CompanyProductListsBulkRestApi\Business\Reader\CompanyReaderInterface;
use FondOfImpala\Zed\CompanyProductListsBulkRestApi\Business\Reader\ProductListReader;
use FondOfImpala\Zed\CompanyProductListsBulkRestApi\Business\Reader\ProductListReaderInterface;
use FondOfImpala\Zed\CompanyProductListsBulkRestApi\CompanyProductListsBulkRestApiDependencyProvider;
use FondOfImpala\Zed\CompanyProductListsBulkRestApi\Dependency\Facade\CompanyProductListsBulkRestApiToCompanyProductListConnectorFacadeInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfImpala\Zed\CompanyProductListsBulkRestApi\Persistence\CompanyProductListsBulkRestApiRepositoryInterface getRepository()
 */
class CompanyProductListsBulkRestApiBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfImpala\Zed\CompanyProductListsBulkRestApi\Business\Persister\CompanyProductListRelationPersisterInterface
     */
    public function createCompanyProductListRelationPersister(): CompanyProductListRelationPersisterInterface
    {
        return new CompanyProductListRelationPersister(
            $this->createCompanyProductListRelationMapper(),
            $this->getCompanyProductListConnectorFacade(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CompanyProductListsBulkRestApi\Business\Expander\RestProductListsBulkRequestExpanderInterface
     */
    public function createRestProductListsBulkRequestExpander(): RestProductListsBulkRequestExpanderInterface
    {
        return new RestProductListsBulkRequestExpander(
            $this->createGroupedIdentifierFilter(),
            $this->createCompanyReader(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CompanyProductListsBulkRestApi\Business\Mapper\CompanyProductListRelationMapperInterface
     */
    protected function createCompanyProductListRelationMapper(): CompanyProductListRelationMapperInterface
    {
        return new CompanyProductListRelationMapper(
            $this->createProductListIdsFilter(),
            $this->createProductListReader(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CompanyProductListsBulkRestApi\Business\Filter\ProductListIdsFilter
     */
    protected function createProductListIdsFilter(): ProductListIdsFilter
    {
        return new ProductListIdsFilter();
    }

    /**
     * @return \FondOfImpala\Zed\CompanyProductListsBulkRestApi\Business\Reader\ProductListReaderInterface
     */
    protected function createProductListReader(): ProductListReaderInterface
    {
        return new ProductListReader(
            $this->getCompanyProductListConnectorFacade(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\CompanyProductListsBulkRestApi\Business\Filter\GroupedIdentifierFilterInterface
     */
    protected function createGroupedIdentifierFilter(): GroupedIdentifierFilterInterface
    {
        return new GroupedIdentifierFilter();
    }

    /**
     * @return \FondOfImpala\Zed\CompanyProductListsBulkRestApi\Business\Reader\CompanyReaderInterface
     */
    protected function createCompanyReader(): CompanyReaderInterface
    {
        return new CompanyReader($this->getRepository());
    }

    /**
     * @return \FondOfImpala\Zed\CompanyProductListsBulkRestApi\Dependency\Facade\CompanyProductListsBulkRestApiToCompanyProductListConnectorFacadeInterface
     */
    protected function getCompanyProductListConnectorFacade(): CompanyProductListsBulkRestApiToCompanyProductListConnectorFacadeInterface
    {
        return $this->getProvidedDependency(
            CompanyProductListsBulkRestApiDependencyProvider::FACADE_COMPANY_PRODUCT_LIST_CONNECTOR,
        );
    }
}
