<?php

namespace FondOfImpala\Zed\ErpOrderCancellationApi\Persistence;

use FondOfImpala\Zed\ErpOrderCancellationApi\Dependency\Facade\ErpOrderCancellationApiToApiFacadeInterface;
use FondOfImpala\Zed\ErpOrderCancellationApi\Dependency\QueryContainer\ErpOrderCancellationApiToApiQueryBuilderQueryContainerInterface;
use FondOfImpala\Zed\ErpOrderCancellationApi\ErpOrderCancellationApiDependencyProvider;
use Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellationQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @codeCoverageIgnore
 *
 * @method \FondOfImpala\Zed\ErpOrderCancellationApi\Persistence\ErpOrderCancellationApiRepositoryInterface getRepository()
 * @method \FondOfImpala\Zed\ErpOrderCancellationApi\ErpOrderCancellationApiConfig getConfig()
 */
class ErpOrderCancellationApiPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellationQuery
     */
    public function getErpOrderCancellationQuery(): FoiErpOrderCancellationQuery
    {
        return $this->getProvidedDependency(ErpOrderCancellationApiDependencyProvider::PROPEL_QUERY_ERP_ORDER_CANCELLATION);
    }

    /**
     * @return \FondOfImpala\Zed\ErpOrderCancellationApi\Dependency\QueryContainer\ErpOrderCancellationApiToApiQueryBuilderQueryContainerInterface
     */
    public function getApiQueryBuilderQueryContainer(): ErpOrderCancellationApiToApiQueryBuilderQueryContainerInterface
    {
        return $this->getProvidedDependency(ErpOrderCancellationApiDependencyProvider::QUERY_CONTAINER_API_QUERY_BUILDER);
    }

    /**
     * @return \FondOfImpala\Zed\ErpOrderCancellationApi\Dependency\Facade\ErpOrderCancellationApiToApiFacadeInterface
     */
    public function getApiFacade(): ErpOrderCancellationApiToApiFacadeInterface
    {
        return $this->getProvidedDependency(ErpOrderCancellationApiDependencyProvider::FACADE_API);
    }
}
