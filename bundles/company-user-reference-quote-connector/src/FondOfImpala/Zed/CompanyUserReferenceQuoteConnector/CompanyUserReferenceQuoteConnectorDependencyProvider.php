<?php

namespace FondOfImpala\Zed\CompanyUserReferenceQuoteConnector;

use FondOfImpala\Zed\CompanyUserReferenceQuoteConnector\Dependency\Facade\CompanyUserReferenceQuoteConnectorToQuoteFacadeBridge;
use Orm\Zed\Quote\Persistence\SpyQuoteQuery;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

/**
 * @codeCoverageIgnore
 */
class CompanyUserReferenceQuoteConnectorDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const PROPEL_QUERY_QUOTE = 'PROPEL_QUERY_QUOTE';

    /**
     * @var string
     */
    public const FACADE_QUOTE = 'FACADE_QUOTE';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::provideBusinessLayerDependencies($container);

        $container = $this->addQuoteFacade($container);

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

        $container = $this->addQuoteQuery($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addQuoteQuery(Container $container): Container
    {
        $container[static::PROPEL_QUERY_QUOTE] = static function () {
            return SpyQuoteQuery::create();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addQuoteFacade(Container $container): Container
    {
        $container[static::FACADE_QUOTE] = static function (Container $container) {
            return new CompanyUserReferenceQuoteConnectorToQuoteFacadeBridge(
                $container->getLocator()->quote()->facade(),
            );
        };

        return $container;
    }
}
