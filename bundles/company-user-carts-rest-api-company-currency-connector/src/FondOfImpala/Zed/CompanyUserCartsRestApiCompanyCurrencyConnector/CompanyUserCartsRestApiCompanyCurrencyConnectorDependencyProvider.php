<?php

namespace FondOfImpala\Zed\CompanyUserCartsRestApiCompanyCurrencyConnector;

use FondOfImpala\Zed\CompanyUserCartsRestApiCompanyCurrencyConnector\Dependency\Facade\CompanyUserCartsRestApiCompanyCurrencyConnectorToCurrencyFacadeBridge;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

/**
 * @codeCoverageIgnore
 */
class CompanyUserCartsRestApiCompanyCurrencyConnectorDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const FACADE_CURRENCY = 'FACADE_CURRENCY';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideCommunicationLayerDependencies(Container $container): Container
    {
        $container = parent::provideCommunicationLayerDependencies($container);

        return $this->addCurrencyFacade($container);
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCurrencyFacade(Container $container): Container
    {
        $container[static::FACADE_CURRENCY] = static function (Container $container) {
            return new CompanyUserCartsRestApiCompanyCurrencyConnectorToCurrencyFacadeBridge(
                $container->getLocator()->currency()->facade(),
            );
        };

        return $container;
    }
}
