<?php

namespace FondOfImpala\Zed\CurrencyCompanySearchRestApi;

use FondOfImpala\Zed\CurrencyCompanySearchRestApi\Dependency\Facade\CurrencyCompanySearchRestApiToCurrencyFacadeBridge;
use FondOfImpala\Zed\CurrencyCompanySearchRestApi\Dependency\Facade\CurrencyCompanySearchRestApiToCurrencyFacadeInterface;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

/**
 * @codeCoverageIgnore
 */
class CurrencyCompanySearchRestApiDependencyProvider extends AbstractBundleDependencyProvider
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
        $container[static::FACADE_CURRENCY] = static fn (
            Container $container
        ): CurrencyCompanySearchRestApiToCurrencyFacadeInterface => new CurrencyCompanySearchRestApiToCurrencyFacadeBridge(
            $container->getLocator()->currency()->facade(),
        );

        return $container;
    }
}
