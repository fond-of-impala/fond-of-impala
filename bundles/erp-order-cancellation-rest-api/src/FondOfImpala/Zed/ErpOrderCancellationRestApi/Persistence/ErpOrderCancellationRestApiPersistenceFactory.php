<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Persistence;

use FondOfImpala\Zed\ErpOrderCancellationRestApi\Dependency\Facade\ErpOrderCancellationRestApiToErpOrderFacadeInterface;
use FondOfImpala\Zed\ErpOrderCancellationRestApi\ErpOrderCancellationRestApiDependencyProvider;
use FondOfImpala\Zed\ErpOrderCancellationRestApi\Persistence\Propel\Expander\QueryExpander;
use FondOfImpala\Zed\ErpOrderCancellationRestApi\Persistence\Propel\Expander\QueryExpanderInterface;
use FondOfImpala\Zed\ErpOrderCancellationRestApi\Persistence\Propel\Mapper\EntityToTransferMapper;
use FondOfImpala\Zed\ErpOrderCancellationRestApi\Persistence\Propel\Mapper\EntityToTransferMapperInterface;
use Orm\Zed\CompanyUser\Persistence\SpyCompanyUserQuery;
use Orm\Zed\Customer\Persistence\SpyCustomerQuery;
use Orm\Zed\ErpOrder\Persistence\FooErpOrderQuery;
use Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellationQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

class ErpOrderCancellationRestApiPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \FondOfImpala\Zed\ErpOrderCancellationRestApi\Persistence\Propel\Expander\QueryExpanderInterface
     */
    public function createQueryExpander(): QueryExpanderInterface
    {
        return new QueryExpander(
            $this->getErpOrderCancellationQueryExpanderPlugins(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\ErpOrderCancellationRestApi\Persistence\Propel\Mapper\EntityToTransferMapperInterface
     */
    public function createEntityToTransferMapper(): EntityToTransferMapperInterface
    {
        return new EntityToTransferMapper();
    }

    /**
     * @return \Orm\Zed\Customer\Persistence\SpyCustomerQuery
     */
    public function getCustomerQuery(): SpyCustomerQuery
    {
        return $this->getProvidedDependency(ErpOrderCancellationRestApiDependencyProvider::QUERY_SPY_CUSTOMER);
    }

    /**
     * @return \Orm\Zed\CompanyUser\Persistence\SpyCompanyUserQuery
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    public function getCompanyUserQuery(): SpyCompanyUserQuery
    {
        return $this->getProvidedDependency(ErpOrderCancellationRestApiDependencyProvider::QUERY_SPY_COMPANY_USER);
    }

    /**
     * @return \Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellationQuery
     */
    public function getErpOrderCancellationQuery(): FoiErpOrderCancellationQuery
    {
        return $this->getProvidedDependency(ErpOrderCancellationRestApiDependencyProvider::QUERY_FOI_ERP_ORDER_CANCELLATION);
    }

    /**
     * @return \FondOfImpala\Zed\ErpOrderCancellationRestApi\Dependency\Facade\ErpOrderCancellationRestApiToErpOrderFacadeInterface
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    public function getErpOrderFacade(): ErpOrderCancellationRestApiToErpOrderFacadeInterface
    {
        return $this->getProvidedDependency(ErpOrderCancellationRestApiDependencyProvider::FACADE_ERP_ORDER);
    }

    /**
     * @return \Orm\Zed\ErpOrder\Persistence\FooErpOrderQuery
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    public function getErpOrderQuery(): FooErpOrderQuery
    {
        return $this->getProvidedDependency(ErpOrderCancellationRestApiDependencyProvider::QUERY_FOO_ERP_ORDER);
    }

    /**
     * @return array<\FondOfImpala\Zed\ErpOrderCancellationRestApiExtension\Dependency\Plugin\ErpOrderCancellationQueryExpanderPluginInterface>
     */
    public function getErpOrderCancellationQueryExpanderPlugins(): array
    {
        return $this->getProvidedDependency(ErpOrderCancellationRestApiDependencyProvider::PLUGINS_ERP_ORDER_CANCELLATION_QUERY_EXPANDER);
    }
}
