<?php

namespace FondOfImpala\Zed\CustomerProductListsBulkRestApi;

use FondOfImpala\Zed\CustomerProductListsBulkRestApi\Dependency\Facade\CustomerProductListsBulkRestApiToCustomerProductListConnectorFacadeBridge;
use FondOfImpala\Zed\CustomerProductListsBulkRestApi\Dependency\Facade\CustomerProductListsBulkRestApiToCustomerProductListConnectorFacadeInterface;
use Orm\Zed\Customer\Persistence\Base\SpyCustomerQuery as BaseSpyCustomerQuery;
use Orm\Zed\Customer\Persistence\SpyCustomerQuery;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

/**
 * @codeCoverageIgnore
 */
class CustomerProductListsBulkRestApiDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const PROPEL_QUERY_CUSTOMER = 'PROPEL_QUERY_CUSTOMER';

    /**
     * @var string
     */
    public const FACADE_CUSTOMER_PRODUCT_LIST_CONNECTOR = 'FACADE_CUSTOMER_PRODUCT_LIST_CONNECTOR';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::provideBusinessLayerDependencies($container);

        return $this->addCustomerProductListConnectorFacade($container);
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCustomerProductListConnectorFacade(Container $container): Container
    {
        $container[static::FACADE_CUSTOMER_PRODUCT_LIST_CONNECTOR] = static fn (
            Container $container
        ): CustomerProductListsBulkRestApiToCustomerProductListConnectorFacadeInterface => new CustomerProductListsBulkRestApiToCustomerProductListConnectorFacadeBridge(
            $container->getLocator()->customerProductListConnector()->facade(),
        );

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function providePersistenceLayerDependencies(Container $container): Container
    {
        $container = parent::providePersistenceLayerDependencies($container);

        return $this->addCustomerQuery($container);
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCustomerQuery(Container $container): Container
    {
        $container[static::PROPEL_QUERY_CUSTOMER] = static fn (): BaseSpyCustomerQuery => SpyCustomerQuery::create();

        return $container;
    }
}
