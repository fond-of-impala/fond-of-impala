<?php

namespace FondOfImpala\Zed\NavisionCompanyBusinessUnit;

use Orm\Zed\CompanyBusinessUnit\Persistence\SpyCompanyBusinessUnitQuery;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class NavisionCompanyBusinessUnitDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const PROPEL_QUERY_COMPANY_BUSINESS_UNIT = 'PROPEL_QUERY_COMPANY_BUSINESS_UNIT';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function providePersistenceLayerDependencies(Container $container): Container
    {
        $container = parent::providePersistenceLayerDependencies($container);

        return $this->addCompanyBusinessUnitPropelQuery($container);
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCompanyBusinessUnitPropelQuery(Container $container): Container
    {
        $container[static::PROPEL_QUERY_COMPANY_BUSINESS_UNIT] = static fn () => SpyCompanyBusinessUnitQuery::create();

        return $container;
    }
}
