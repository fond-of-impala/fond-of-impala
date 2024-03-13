<?php

namespace FondOfImpala\Glue\PriceProductPriceListSearchRestApi;

use FondOfImpala\Glue\PriceProductPriceListSearchRestApi\Dependency\Client\PriceProductPriceListSearchRestApiToPriceProductPriceListPageSearchClientBridge;
use Spryker\Glue\Kernel\AbstractBundleDependencyProvider;
use Spryker\Glue\Kernel\Container;

class PriceProductPriceListSearchRestApiDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const CLIENT_PRICE_PRODUCT_PRICE_LIST_PAGE_SEARCH = 'CLIENT_PRICE_PRODUCT_PRICE_LIST_PAGE_SEARCH';

    /**
     * @var string
     */
    public const PLUGINS_REDUCER = 'PLUGINS_REDUCER';

    /**
     * @param \Spryker\Glue\Kernel\Container $container
     *
     * @return \Spryker\Glue\Kernel\Container
     */
    public function provideDependencies(Container $container): Container
    {
        $container = parent::provideDependencies($container);

        $container = $this->addPriceProductPriceListPageSearchClient($container);

        return $this->addReducerPlugins($container);
    }

    /**
     * @param \Spryker\Glue\Kernel\Container $container
     *
     * @return \Spryker\Glue\Kernel\Container
     */
    protected function addPriceProductPriceListPageSearchClient(Container $container): Container
    {
        $container[static::CLIENT_PRICE_PRODUCT_PRICE_LIST_PAGE_SEARCH] = fn (Container $container): PriceProductPriceListSearchRestApiToPriceProductPriceListPageSearchClientBridge => new PriceProductPriceListSearchRestApiToPriceProductPriceListPageSearchClientBridge(
            $container->getLocator()->priceProductPriceListPageSearch()->client(),
        );

        return $container;
    }

    /**
     * @param \Spryker\Glue\Kernel\Container $container
     *
     * @return \Spryker\Glue\Kernel\Container
     */
    protected function addReducerPlugins(Container $container): Container
    {
        $self = $this;
        $container[static::PLUGINS_REDUCER] = function () use ($self) {
            return $self->getReducerPlugins();
        };

        return $container;
    }

    /**
     * @return array<\FondOfImpala\Glue\PriceProductPriceListSearchRestApiExtension\Plugin\ReducerPluginInterface>
     */
    protected function getReducerPlugins(): array
    {
        return [];
    }
}
