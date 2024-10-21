<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi\Business;

use FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\Model\CancellationManager;
use FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\Model\CancellationManagerInterface;
use FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\Model\Mapper\RestDataMapper;
use FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\Model\Mapper\RestDataMapperInterface;
use FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\Model\Mapper\RestFilterToFilterMapper;
use FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\Model\Mapper\RestFilterToFilterMapperInterface;
use FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\Model\Permission\PermissionChecker;
use FondOfImpala\Zed\ErpOrderCancellationRestApi\Dependency\Facade\ErpOrderCancellationRestApiToErpOrderCancellationFacadeInterface;
use FondOfImpala\Zed\ErpOrderCancellationRestApi\Dependency\Facade\ErpOrderCancellationRestApiToErpOrderFacadeInterface;
use FondOfImpala\Zed\ErpOrderCancellationRestApi\ErpOrderCancellationRestApiDependencyProvider;
use Spryker\Shared\Log\LoggerTrait;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfImpala\Zed\ErpOrderCancellationRestApi\Persistence\ErpOrderCancellationRestApiRepositoryInterface getRepository()
 */
class ErpOrderCancellationRestApiBusinessFactory extends AbstractBusinessFactory
{
    use LoggerTrait;

    /**
     * @return \FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\Model\CancellationManagerInterface
     */
    public function createCancellationManager(): CancellationManagerInterface
    {
        return new CancellationManager(
            $this->getErpOrderCancellationFacade(),
            $this->getErpOrderFacade(),
            $this->getRepository(),
            $this->createRestDataMapper(),
            $this->createPermissionChecker(),
            $this->createRestFilterToFilterMapper(),
            $this->getLogger(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\Model\Mapper\RestDataMapperInterface
     */
    public function createRestDataMapper(): RestDataMapperInterface
    {
        return new RestDataMapper();
    }

    /**
     * @return \FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\Model\Permission\PermissionChecker
     */
    public function createPermissionChecker(): PermissionChecker
    {
        return new PermissionChecker($this->getErpOrderCancellationPermissionPlugins());
    }

    /**
     * @return \FondOfImpala\Zed\ErpOrderCancellationRestApi\Business\Model\Mapper\RestFilterToFilterMapperInterface
     */
    public function createRestFilterToFilterMapper(): RestFilterToFilterMapperInterface
    {
        return new RestFilterToFilterMapper($this->getRestFilterToFilterMapperExpanderPlugins());
    }

    /**
     * @return \FondOfImpala\Zed\ErpOrderCancellationRestApi\Dependency\Facade\ErpOrderCancellationRestApiToErpOrderCancellationFacadeInterface
     */
    protected function getErpOrderCancellationFacade(): ErpOrderCancellationRestApiToErpOrderCancellationFacadeInterface
    {
        return $this->getProvidedDependency(ErpOrderCancellationRestApiDependencyProvider::FACADE_ERP_ORDER_CANCELLATION);
    }

    /**
     * @return \FondOfImpala\Zed\ErpOrderCancellationRestApi\Dependency\Facade\ErpOrderCancellationRestApiToErpOrderFacadeInterface
     */
    protected function getErpOrderFacade(): ErpOrderCancellationRestApiToErpOrderFacadeInterface
    {
        return $this->getProvidedDependency(ErpOrderCancellationRestApiDependencyProvider::FACADE_ERP_ORDER);
    }

    /**
     * @return array<\FondOfImpala\Zed\ErpOrderCancellationRestApiExtension\Dependency\Plugin\ErpOrderCancellationRestFilterToFilterMapperExpanderPluginInterface>
     */
    protected function getRestFilterToFilterMapperExpanderPlugins(): array
    {
        return $this->getProvidedDependency(ErpOrderCancellationRestApiDependencyProvider::PLUGINS_ERP_ORDER_CANCELLATION_REST_FILTER_TO_FILTER_MAPPER_EXPANDER);
    }

    /**
     * @return array<\FondOfImpala\Zed\ErpOrderCancellationRestApiExtension\Dependency\Plugin\ErpOrderCancellationPermissionPluginInterface>
     */
    protected function getErpOrderCancellationPermissionPlugins(): array
    {
        return $this->getProvidedDependency(ErpOrderCancellationRestApiDependencyProvider::PLUGINS_ERP_ORDER_CANCELLATION_PERMISSION);
    }
}
