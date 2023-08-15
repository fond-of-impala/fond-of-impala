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
     * @param \Spryker\Glue\Kernel\Container $container
     *
     * @return \Spryker\Glue\Kernel\Container
     */
    public function provideDependencies(Container $container): Container
    {
        $container = parent::provideDependencies($container);

        $container = $this->addPriceProductPriceListPageSearchClient($container);

        return $container;
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
}
