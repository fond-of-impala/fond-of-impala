<?php

namespace FondOfImpala\Zed\CompanyProductListsBulkRestApi;

use FondOfImpala\Zed\CompanyProductListsBulkRestApi\Dependency\Facade\CompanyProductListsBulkRestApiToCompanyProductListConnectorFacadeBridge;
use FondOfImpala\Zed\CompanyProductListsBulkRestApi\Dependency\Facade\CompanyProductListsBulkRestApiToCompanyProductListConnectorFacadeInterface;
use Orm\Zed\Company\Persistence\Base\SpyCompanyQuery as BaseSpyCompanyQuery;
use Orm\Zed\Company\Persistence\SpyCompanyQuery;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

/**
 * @codeCoverageIgnore
 */
class CompanyProductListsBulkRestApiDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const PROPEL_QUERY_COMPANY = 'PROPEL_QUERY_COMPANY';

    /**
     * @var string
     */
    public const FACADE_COMPANY_PRODUCT_LIST_CONNECTOR = 'FACADE_COMPANY_PRODUCT_LIST_CONNECTOR';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::provideBusinessLayerDependencies($container);

        return $this->addCompanyProductListConnectorFacade($container);
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCompanyProductListConnectorFacade(Container $container): Container
    {
        $container[static::FACADE_COMPANY_PRODUCT_LIST_CONNECTOR] = static fn (
            Container $container
        ): CompanyProductListsBulkRestApiToCompanyProductListConnectorFacadeInterface => new CompanyProductListsBulkRestApiToCompanyProductListConnectorFacadeBridge(
            $container->getLocator()->companyProductListConnector()->facade(),
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

        return $this->addCompanyQuery($container);
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCompanyQuery(Container $container): Container
    {
        $container[static::PROPEL_QUERY_COMPANY] = static fn (): BaseSpyCompanyQuery => SpyCompanyQuery::create();

        return $container;
    }
}
