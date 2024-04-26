<?php

namespace FondOfImpala\Zed\WebUiSettingsCustomerConnector;

use FondOfImpala\Zed\WebUiSettingsCustomerConnector\Dependency\Facade\WebUiSettingsCustomerConnectorToWebUiSettingsFacadeBridge;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class WebUiSettingsCustomerConnectorDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const FACADE_WEB_UI_SETTINGS = 'FACADE_WEB_UI_SETTINGS';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::provideBusinessLayerDependencies($container);

        return $this->addWebUiSettingsFacade($container);
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addWebUiSettingsFacade(Container $container): Container
    {
        $container[static::FACADE_WEB_UI_SETTINGS] = static fn (Container $container): WebUiSettingsCustomerConnectorToWebUiSettingsFacadeBridge => new WebUiSettingsCustomerConnectorToWebUiSettingsFacadeBridge(
            $container->getLocator()->webUiSettings()->facade(),
        );

        return $container;
    }
}
