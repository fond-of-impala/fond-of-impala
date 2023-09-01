<?php

namespace FondOfImpala\Zed\PriceListApi\Business;

use FondOfImpala\Zed\PriceListApi\Business\Hydrator\PriceProductsHydrator;
use FondOfImpala\Zed\PriceListApi\Business\Hydrator\PriceProductsHydratorInterface;
use FondOfImpala\Zed\PriceListApi\Business\Mapper\TransferMapper;
use FondOfImpala\Zed\PriceListApi\Business\Mapper\TransferMapperInterface;
use FondOfImpala\Zed\PriceListApi\Business\Model\PriceListApi;
use FondOfImpala\Zed\PriceListApi\Business\Model\PriceListApiInterface;
use FondOfImpala\Zed\PriceListApi\Business\Validator\PriceListApiValidator;
use FondOfImpala\Zed\PriceListApi\Business\Validator\PriceListApiValidatorInterface;
use FondOfImpala\Zed\PriceListApi\Dependency\Facade\PriceListApiToApiFacadeInterface;
use FondOfImpala\Zed\PriceListApi\Dependency\Facade\PriceListApiToPriceListFacadeInterface;
use FondOfImpala\Zed\PriceListApi\Dependency\Facade\PriceListApiToPriceProductPriceListFacadeInterface;
use FondOfImpala\Zed\PriceListApi\Dependency\Facade\PriceListApiToProductFacadeInterface;
use FondOfImpala\Zed\PriceListApi\Dependency\QueryContainer\PriceListApiToApiQueryBuilderQueryContainerInterface;
use FondOfImpala\Zed\PriceListApi\PriceListApiDependencyProvider;
use Propel\Runtime\Connection\ConnectionInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfImpala\Zed\PriceListApi\PriceListApiConfig getConfig()
 * @method \FondOfImpala\Zed\PriceListApi\Persistence\PriceListApiQueryContainerInterface getQueryContainer()
 * @method \FondOfImpala\Zed\PriceListApi\Persistence\PriceListApiRepositoryInterface getRepository()
 */
class PriceListApiBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfImpala\Zed\PriceListApi\Business\Hydrator\PriceProductsHydratorInterface
     */
    public function createPriceProductsHydrator(): PriceProductsHydratorInterface
    {
        return new PriceProductsHydrator(
            $this->getProductFacade(),
            $this->getRepository(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\PriceListApi\Business\Model\PriceListApiInterface
     */
    public function createProductListApi(): PriceListApiInterface
    {
        return new PriceListApi(
            $this->getPropelConnection(),
            $this->getPriceListFacade(),
            $this->getPriceProductPriceListFacade(),
            $this->createApiDataTransferMapper(),
            $this->getApiFacade(),
            $this->getApiQueryBuilderQueryContainer(),
            $this->getQueryContainer(),
            $this->getPriceProductsHydrationPlugins(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\PriceListApi\Business\Validator\PriceListApiValidatorInterface
     */
    public function createPriceListApiValidator(): PriceListApiValidatorInterface
    {
        return new PriceListApiValidator();
    }

    /**
     * @return \FondOfImpala\Zed\PriceListApi\Business\Mapper\TransferMapperInterface
     */
    protected function createApiDataTransferMapper(): TransferMapperInterface
    {
        return new TransferMapper();
    }

    /**
     * @return \FondOfImpala\Zed\PriceListApi\Dependency\Facade\PriceListApiToProductFacadeInterface
     */
    protected function getProductFacade(): PriceListApiToProductFacadeInterface
    {
        return $this->getProvidedDependency(PriceListApiDependencyProvider::FACADE_PRODUCT);
    }

    /**
     * @return \FondOfImpala\Zed\PriceListApi\Dependency\Facade\PriceListApiToPriceListFacadeInterface
     */
    protected function getPriceListFacade(): PriceListApiToPriceListFacadeInterface
    {
        return $this->getProvidedDependency(PriceListApiDependencyProvider::FACADE_PRICE_LIST);
    }

    /**
     * @return \FondOfImpala\Zed\PriceListApi\Dependency\Facade\PriceListApiToPriceProductPriceListFacadeInterface
     */
    protected function getPriceProductPriceListFacade(): PriceListApiToPriceProductPriceListFacadeInterface
    {
        return $this->getProvidedDependency(PriceListApiDependencyProvider::FACADE_PRICE_PRODUCT_PRICE_LIST);
    }

    /**
     * @return array<\FondOfImpala\Zed\PriceListApi\Dependency\Plugin\PriceProductsHydrationPluginInterface>
     */
    protected function getPriceProductsHydrationPlugins(): array
    {
        return $this->getProvidedDependency(PriceListApiDependencyProvider::PLUGINS_PRICE_PRODUCTS_HYDRATION);
    }

    /**
     * @return \Propel\Runtime\Connection\ConnectionInterface
     */
    protected function getPropelConnection(): ConnectionInterface
    {
        return $this->getProvidedDependency(PriceListApiDependencyProvider::PROPEL_CONNECTION);
    }

    /**
     * @return \FondOfImpala\Zed\PriceListApi\Dependency\Facade\PriceListApiToApiFacadeInterface
     */
    protected function getApiFacade(): PriceListApiToApiFacadeInterface
    {
        return $this->getProvidedDependency(PriceListApiDependencyProvider::FACADE_API);
    }

    /**
     * @return \FondOfImpala\Zed\PriceListApi\Dependency\QueryContainer\PriceListApiToApiQueryBuilderQueryContainerInterface
     */
    protected function getApiQueryBuilderQueryContainer(): PriceListApiToApiQueryBuilderQueryContainerInterface
    {
        return $this->getProvidedDependency(PriceListApiDependencyProvider::QUERY_CONTAINER_API_QUERY_BUILDER);
    }
}
