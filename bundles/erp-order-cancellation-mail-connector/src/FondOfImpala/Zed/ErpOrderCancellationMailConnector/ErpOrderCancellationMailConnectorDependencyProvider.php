<?php

namespace FondOfImpala\Zed\ErpOrderCancellationMailConnector;

use ArrayObject;
use FondOfImpala\Zed\ErpOrderCancellationMailConnector\Dependency\Facade\ErpOrderCancellationMailConnectorToLocaleFacadeBridge;
use FondOfImpala\Zed\ErpOrderCancellationMailConnector\Dependency\Facade\ErpOrderCancellationMailConnectorToMailFacadeBridge;
use FondOfImpala\Zed\ErpOrderCancellationMailConnector\Exception\WrongInterfaceException;
use FondOfImpala\Zed\ErpOrderCancellationMailConnectorExtension\Dependency\Plugin\ErpOrderCancellationMailConnectorItemPostSavePluginInterface;
use FondOfImpala\Zed\ErpOrderCancellationMailConnectorExtension\Dependency\Plugin\ErpOrderCancellationMailConnectorItemPreSavePluginInterface;
use FondOfImpala\Zed\ErpOrderCancellationMailConnectorExtension\Dependency\Plugin\ErpOrderCancellationMailConnectorPostSavePluginInterface;
use FondOfImpala\Zed\ErpOrderCancellationMailConnectorExtension\Dependency\Plugin\ErpOrderCancellationMailConnectorPreSavePluginInterface;
use Orm\Zed\Company\Persistence\SpyCompanyQuery;
use Orm\Zed\CompanyRole\Persistence\SpyCompanyRoleQuery;
use Orm\Zed\Customer\Persistence\SpyCustomerQuery;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class ErpOrderCancellationMailConnectorDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const FACADE_MAIL = 'FACADE_MAIL';

    /**
     * @var string
     */
    public const FACADE_LOCALE = 'FACADE_LOCALE';

    /**
     * @var string
     */
    public const PROPEL_QUERY_COMPANY = 'PROPEL_QUERY_COMPANY';

    /**
     * @var string
     */
    public const PROPEL_QUERY_CUSTOMER = 'PROPEL_QUERY_CUSTOMER';

    /**
     * @var string
     */
    public const PROPEL_QUERY_COMPANY_ROLE = 'PROPEL_QUERY_COMPANY_ROLE';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::providePersistenceLayerDependencies($container);
        $container = $this->addLocaleFacade($container);

        return $this->addMailFacade($container);
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function providePersistenceLayerDependencies(Container $container): Container
    {
        $container = parent::providePersistenceLayerDependencies($container);
        $container = $this->addSpyCustomerQuery($container);
        $container = $this->addSpyCompanyRoleQuery($container);

        return $this->addSpyCompanyQuery($container);
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function addMailFacade(Container $container): Container
    {
        $container[static::FACADE_MAIL] = static function () use ($container) {
            return new ErpOrderCancellationMailConnectorToMailFacadeBridge($container->getLocator()->mail()->facade());
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function addLocaleFacade(Container $container): Container
    {
        $container[static::FACADE_LOCALE] = static function () use ($container) {
            return new ErpOrderCancellationMailConnectorToLocaleFacadeBridge($container->getLocator()->locale()->facade());
        };

        return $container;
    }

    /**
     * @codeCoverageIgnore
     *
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addSpyCompanyQuery(Container $container): Container
    {
        $container[static::PROPEL_QUERY_COMPANY] = static function () {
            return SpyCompanyQuery::create();
        };

        return $container;
    }

    /**
     * @codeCoverageIgnore
     *
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addSpyCompanyRoleQuery(Container $container): Container
    {
        $container[static::PROPEL_QUERY_COMPANY_ROLE] = static function () {
            return SpyCompanyRoleQuery::create();
        };

        return $container;
    }

    /**
     * @codeCoverageIgnore
     *
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addSpyCustomerQuery(Container $container): Container
    {
        $container[static::PROPEL_QUERY_CUSTOMER] = static function () {
            return SpyCustomerQuery::create();
        };

        return $container;
    }

}
