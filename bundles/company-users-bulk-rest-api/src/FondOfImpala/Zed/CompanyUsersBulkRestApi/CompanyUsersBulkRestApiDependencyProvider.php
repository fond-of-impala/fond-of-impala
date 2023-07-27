<?php

namespace FondOfImpala\Zed\CompanyUsersBulkRestApi;

use FondOfImpala\Zed\CompanyUsersBulkRestApi\Dependency\Facade\CompanyUsersBulkRestApiToCompanyUserFacadeBridge;
use FondOfImpala\Zed\CompanyUsersBulkRestApi\Dependency\Facade\CompanyUsersBulkRestApiToEventFacadeBridge;
use Orm\Zed\Company\Persistence\SpyCompanyQuery;
use Orm\Zed\CompanyBusinessUnit\Persistence\SpyCompanyBusinessUnitQuery;
use Orm\Zed\CompanyRole\Persistence\SpyCompanyRoleQuery;
use Orm\Zed\CompanyUser\Persistence\SpyCompanyUserQuery;
use Orm\Zed\Customer\Persistence\SpyCustomerQuery;
use Orm\Zed\Permission\Persistence\SpyPermissionQuery;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class CompanyUsersBulkRestApiDependencyProvider extends AbstractBundleDependencyProvider
{
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
    public const QUERY_SPY_CUSTOMER = 'QUERY_SPY_CUSTOMER';

    /**
     * @var string
     */
    public const PROPEL_QUERY_PERMISSION = 'PROPEL_QUERY_PERMISSION';

    /**
     * @var string
     */
    public const QUERY_SPY_COMPANY_BUSINESS_UNIT = 'QUERY_SPY_COMPANY_BUSINESS_UNIT';

    /**
     * @var string
     */
    public const QUERY_SPY_COMPANY_ROLE = 'QUERY_SPY_COMPANY_ROLE';

    /**
     * @var string
     */
    public const FACADE_EVENT = 'FACADE_EVENT';

    /**
     * @var string
     */
    public const FACADE_COMPANY_USER = 'FACADE_COMPANY_USER';

    /**
     * @var string
     */
    public const PLUGINS_DATA_EXPANDER = 'PLUGINS_DATA_EXPANDER';

    /**
     * @var string
     */
    public const PLUGINS_DATA_POST_EXPANDER = 'PLUGINS_DATA_POST_EXPANDER';

    /**
     * @var string
     */
    public const PLUGINS_PRE_HANDLING = 'PLUGINS_PRE_HANDLING';

    /**
     * @var string
     */
    public const PLUGINS_POST_HANDLING = 'PLUGINS_POST_HANDLING';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function providePersistenceLayerDependencies(Container $container): Container
    {
        $container = parent::providePersistenceLayerDependencies($container);
        $container = $this->addSpyCompanyQuery($container);
        $container = $this->addSpyCompanyUserQuery($container);
        $container = $this->addSpyCustomerQuery($container);
        $container = $this->addSpyCompanyRoleQuery($container);
        $container = $this->addSpyCompanyBusinessUnitQuery($container);

        return $this->addPermissionQuery($container);
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::provideBusinessLayerDependencies($container);
        $container = $this->addCompanyUserFacade($container);
        $container = $this->addDataExpanderPlugins($container);
        $container = $this->addDataPostExpanderPlugins($container);
        $container = $this->addPostHandlingPlugins($container);
        $container = $this->addPreHandlingPlugins($container);

        return $this->addEventFacade($container);
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
    protected function addSpyCompanyUserQuery(Container $container): Container
    {
        $container[static::QUERY_SPY_COMPANY_USER] = static function () {
            return new SpyCompanyUserQuery();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addSpyCompanyQuery(Container $container): Container
    {
        $container[static::QUERY_SPY_COMPANY] = static function () {
            return new SpyCompanyQuery();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addPermissionQuery(Container $container): Container
    {
        $container[static::PROPEL_QUERY_PERMISSION] = static function () {
            return SpyPermissionQuery::create();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addSpyCompanyBusinessUnitQuery(Container $container): Container
    {
        $container[static::QUERY_SPY_COMPANY_BUSINESS_UNIT] = static function () {
            return new SpyCompanyBusinessUnitQuery();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addSpyCompanyRoleQuery(Container $container): Container
    {
        $container[static::QUERY_SPY_COMPANY_ROLE] = static function () {
            return new SpyCompanyRoleQuery();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addEventFacade(Container $container): Container
    {
        $container[static::FACADE_EVENT] = static function (Container $container) {
            return new CompanyUsersBulkRestApiToEventFacadeBridge($container->getLocator()->event()->facade());
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCompanyUserFacade(Container $container): Container
    {
        $container[static::FACADE_COMPANY_USER] = static function (Container $container) {
            return new CompanyUsersBulkRestApiToCompanyUserFacadeBridge($container->getLocator()->companyUser()->facade());
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addDataExpanderPlugins(Container $container): Container
    {
        $self = $this;
        $container[static::PLUGINS_DATA_EXPANDER] = static function (Container $container) use ($self) {
            return $self->getDataExpanderPlugins();
        };

        return $container;
    }

    /**
     * @return array<\FondOfImpala\Zed\CompanyUsersBulkRestApiExtension\Dependency\Plugin\CompanyUsersBulkDataExpanderPluginInterface>
     */
    protected function getDataExpanderPlugins(): array
    {
        return [];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addDataPostExpanderPlugins(Container $container): Container
    {
        $self = $this;
        $container[static::PLUGINS_DATA_POST_EXPANDER] = static function (Container $container) use ($self) {
            return $self->getDataPostExpanderPlugins();
        };

        return $container;
    }

    /**
     * @return array<\FondOfImpala\Zed\CompanyUsersBulkRestApiExtension\Dependency\Plugin\CompanyUsersBulkDataPostExpanderPluginInterface>
     */
    protected function getDataPostExpanderPlugins(): array
    {
        return [];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addPreHandlingPlugins(Container $container): Container
    {
        $self = $this;
        $container[static::PLUGINS_PRE_HANDLING] = static function (Container $container) use ($self) {
            return $self->getPreHandlingPlugins();
        };

        return $container;
    }

    /**
     * @return array<\FondOfImpala\Zed\CompanyUsersBulkRestApiExtension\Dependency\Plugin\CompanyUsersBulkPreHandlingPluginInterface>
     */
    protected function getPreHandlingPlugins(): array
    {
        return [];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addPostHandlingPlugins(Container $container): Container
    {
        $self = $this;
        $container[static::PLUGINS_POST_HANDLING] = static function (Container $container) use ($self) {
            return $self->getPostHandlingPlugins();
        };

        return $container;
    }

    /**
     * @return array<\FondOfImpala\Zed\CompanyUsersBulkRestApiExtension\Dependency\Plugin\CompanyUsersBulkPostHandlingPluginInterface>
     */
    protected function getPostHandlingPlugins(): array
    {
        return [];
    }
}
