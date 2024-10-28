<?php

namespace FondOfImpala\Zed\ErpOrderCancellationRestApi;

use FondOfImpala\Zed\ErpOrderCancellationRestApi\Dependency\Facade\ErpOrderCancellationRestApiToErpOrderCancellationFacadeBridge;
use FondOfImpala\Zed\ErpOrderCancellationRestApi\Dependency\Facade\ErpOrderCancellationRestApiToErpOrderFacadeBridge;
use Orm\Zed\Company\Persistence\SpyCompanyQuery;
use Orm\Zed\CompanyUser\Persistence\SpyCompanyUserQuery;
use Orm\Zed\Customer\Persistence\SpyCustomerQuery;
use Orm\Zed\ErpOrder\Persistence\ErpOrderQuery;
use Orm\Zed\ErpOrderCancellation\Persistence\FoiErpOrderCancellationQuery;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

/**
 * @codeCoverageIgnore
 */
class ErpOrderCancellationRestApiDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const QUERY_SPY_CUSTOMER = 'QUERY_SPY_CUSTOMER';

    /**
     * @var string
     */
    public const QUERY_SPY_COMPANY_USER = 'QUERY_SPY_COMPANY_USER';

    /**
     * @var string
     */
    public const QUERY_SPY_COMPANY = 'QUERY_SPY_COMPANY';

    /**
     * @var string
     */
    public const QUERY_FOI_ERP_ORDER_CANCELLATION = 'QUERY_FOI_ERP_ORDER_CANCELLATION';

    /**
     * @var string
     */
    public const QUERY_FOO_ERP_ORDER = 'QUERY_FOO_ERP_ORDER';

    /**
     * @var string
     */
    public const FACADE_ERP_ORDER_CANCELLATION = 'FACADE_ERP_ORDER_CANCELLATION';

    /**
     * @var string
     */
    public const FACADE_ERP_ORDER = 'FACADE_ERP_ORDER';

    /**
     * @var string
     */
    public const PLUGINS_ERP_ORDER_CANCELLATION_REST_FILTER_TO_FILTER_MAPPER_EXPANDER = 'PLUGINS_ERP_ORDER_CANCELLATION_REST_FILTER_TO_FILTER_MAPPER_EXPANDER';

    /**
     * @var string
     */
    public const PLUGINS_ERP_ORDER_CANCELLATION_QUERY_EXPANDER = 'PLUGINS_ERP_ORDER_CANCELLATION_QUERY_EXPANDER';

    /**
     * @var string
     */
    public const PLUGINS_ERP_ORDER_CANCELLATION_PERMISSION = 'PLUGINS_ERP_ORDER_CANCELLATION_PERMISSION';

    /**
     * @var string
     */
    public const PLUGINS_ERP_ORDER_CANCELLATION_EXPANDER = 'PLUGINS_ERP_ORDER_CANCELLATION_EXPANDER';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function providePersistenceLayerDependencies(Container $container): Container
    {
        $container = parent::providePersistenceLayerDependencies($container);
        $container = $this->addSpyCompanyUserQuery($container);
        $container = $this->addSpyCustomerQuery($container);
        $container = $this->addSpyCompanyQuery($container);
        $container = $this->addErpOrderCancellationQueryExpanderPlugin($container);
        $container = $this->addErpOrderQuery($container);
        $container = $this->addErpOrderFacade($container);

        return $this->addFoiErpOrderCancellationQuery($container);
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::provideBusinessLayerDependencies($container);
        $container = $this->addRestFilterToFilterMapperExpanderPlugin($container);
        $container = $this->addErpOrderFacade($container);
        $container = $this->addErpOrderCancellationPermissionPlugin($container);
        $container = $this->addErpOrderCancellationExpanderPlugin($container);

        return $this->addErpOrderCancellationFacade($container);
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideCommunicationLayerDependencies(Container $container): Container
    {
        $container = parent::provideCommunicationLayerDependencies($container);

        return $this->addErpOrderFacade($container);
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addSpyCustomerQuery(Container $container): Container
    {
        $container[static::QUERY_SPY_CUSTOMER] = static function () {
            return new SpyCustomerQuery();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addErpOrderCancellationFacade(Container $container): Container
    {
        $container[static::FACADE_ERP_ORDER_CANCELLATION] = static function (Container $container) {
            return new ErpOrderCancellationRestApiToErpOrderCancellationFacadeBridge($container->getLocator()->erpOrderCancellation()->facade());
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addErpOrderFacade(Container $container): Container
    {
        $container[static::FACADE_ERP_ORDER] = static function (Container $container) {
            return new ErpOrderCancellationRestApiToErpOrderFacadeBridge($container->getLocator()->erpOrder()->facade());
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function addSpyCompanyUserQuery(Container $container): Container
    {
        $container[static::QUERY_SPY_COMPANY_USER] = static function (Container $container) {
            return SpyCompanyUserQuery::create();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function addSpyCompanyQuery(Container $container): Container
    {
        $container[static::QUERY_SPY_COMPANY] = static function (Container $container) {
            return SpyCompanyQuery::create();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function addErpOrderQuery(Container $container): Container
    {
        $container[static::QUERY_FOO_ERP_ORDER] = static function (Container $container) {
            return ErpOrderQuery::create();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function addFoiErpOrderCancellationQuery(Container $container): Container
    {
        $container[static::QUERY_FOI_ERP_ORDER_CANCELLATION] = static function (Container $container) {
            return FoiErpOrderCancellationQuery::create();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function addRestFilterToFilterMapperExpanderPlugin(Container $container): Container
    {
        $container[static::PLUGINS_ERP_ORDER_CANCELLATION_REST_FILTER_TO_FILTER_MAPPER_EXPANDER] = function () {
            return $this->getRestFilterToFilterMapperExpanderPlugin();
        };

        return $container;
    }

    /**
     * @return array<\FondOfImpala\Zed\ErpOrderCancellationRestApiExtension\Dependency\Plugin\ErpOrderCancellationRestFilterToFilterMapperExpanderPluginInterface>
     */
    protected function getRestFilterToFilterMapperExpanderPlugin(): array
    {
        return [];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function addErpOrderCancellationQueryExpanderPlugin(Container $container): Container
    {
        $container[static::PLUGINS_ERP_ORDER_CANCELLATION_QUERY_EXPANDER] = function () {
            return $this->getErpOrderCancellationQueryExpanderPlugin();
        };

        return $container;
    }

    /**
     * @return array<\FondOfImpala\Zed\ErpOrderCancellationRestApiExtension\Dependency\Plugin\ErpOrderCancellationQueryExpanderPluginInterface>
     */
    protected function getErpOrderCancellationQueryExpanderPlugin(): array
    {
        return [];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function addErpOrderCancellationPermissionPlugin(Container $container): Container
    {
        $container[static::PLUGINS_ERP_ORDER_CANCELLATION_PERMISSION] = function () {
            return $this->getErpOrderCancellationPermissionPlugin();
        };

        return $container;
    }

    /**
     * @return array<\FondOfImpala\Zed\ErpOrderCancellationRestApiExtension\Dependency\Plugin\ErpOrderCancellationPermissionPluginInterface>
     */
    protected function getErpOrderCancellationPermissionPlugin(): array
    {
        return [];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function addErpOrderCancellationExpanderPlugin(Container $container): Container
    {
        $container[static::PLUGINS_ERP_ORDER_CANCELLATION_EXPANDER] = function () {
            return $this->getErpOrderCancellationExpanderPlugin();
        };

        return $container;
    }

    /**
     * @return array<\FondOfImpala\Zed\ErpOrderCancellationRestApiExtension\Dependency\Plugin\ErpOrderCancellationExpanderPluginInterface>
     */
    protected function getErpOrderCancellationExpanderPlugin(): array
    {
        return [];
    }
}
