<?php

namespace FondOfImpala\Zed\PriceListGui;

use FondOfImpala\Zed\PriceListGui\Dependency\Facade\PriceListGuiToPriceListFacadeBridge;
use FondOfImpala\Zed\PriceListGui\Dependency\Service\PriceListGuiToUtilDateTimeServiceBridge;
use Orm\Zed\PriceList\Persistence\FoiPriceListQuery;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class PriceListGuiDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const PROPEL_QUERY_FOS_PRICE_LIST = 'PROPEL_QUERY_FOS_PRICE_LIST';

    /**
     * @var string
     */
    public const FACADE_PRICE_LIST = 'FACADE_PRICE_LIST';

    /**
     * @var string
     */
    public const SERVICE_UTIL_DATE_TIME = 'SERVICE_UTIL_DATE_TIME';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideCommunicationLayerDependencies(Container $container): Container
    {
        $container = parent::provideCommunicationLayerDependencies($container);

        $container = $this->addPriceListFacade($container);
        $container = $this->addPriceListPropelQuery($container);
        $container = $this->addUtilDateTimeService($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addPriceListPropelQuery(Container $container): Container
    {
        $container[static::PROPEL_QUERY_FOS_PRICE_LIST] = fn (): FoiPriceListQuery => FoiPriceListQuery::create();

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addPriceListFacade(Container $container): Container
    {
        $container[static::FACADE_PRICE_LIST] = fn (Container $container): PriceListGuiToPriceListFacadeBridge => new PriceListGuiToPriceListFacadeBridge(
            $container->getLocator()->priceList()->facade(),
        );

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addUtilDateTimeService(Container $container): Container
    {
        $container[static::SERVICE_UTIL_DATE_TIME] = fn (Container $container): PriceListGuiToUtilDateTimeServiceBridge => new PriceListGuiToUtilDateTimeServiceBridge(
            $container->getLocator()->utilDateTime()->service(),
        );

        return $container;
    }
}
