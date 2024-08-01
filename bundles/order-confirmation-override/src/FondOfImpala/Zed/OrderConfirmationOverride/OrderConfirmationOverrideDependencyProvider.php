<?php

namespace FondOfImpala\Zed\OrderConfirmationOverride;

use Orm\Zed\Company\Persistence\SpyCompanyQuery;
use Orm\Zed\Customer\Persistence\SpyCustomerQuery;
use Orm\Zed\Customer\Persistence\Base\SpyCustomerQuery as BaseSpyCustomerQuery;
use Orm\Zed\Company\Persistence\Base\SpyCompanyQuery as BaseSpyCompanyQuery;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

/**
 * @codeCoverageIgnore
 */
class OrderConfirmationOverrideDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const PROPEL_QUERY_CUSTOMER = 'PROPEL_QUERY_CUSTOMER';

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
