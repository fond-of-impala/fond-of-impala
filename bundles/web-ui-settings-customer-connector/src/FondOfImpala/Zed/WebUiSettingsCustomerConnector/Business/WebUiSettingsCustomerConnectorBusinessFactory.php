<?php

namespace FondOfImpala\Zed\WebUiSettingsCustomerConnector\Business;

use FondOfImpala\Zed\WebUiSettingsCustomerConnector\Business\Manager\WebUiSettingsManager;
use FondOfImpala\Zed\WebUiSettingsCustomerConnector\Business\Manager\WebUiSettingsManagerInterface;
use FondOfImpala\Zed\WebUiSettingsCustomerConnector\Dependency\Facade\WebUiSettingsCustomerConnectorToWebUiSettingsFacadeInterface;
use FondOfImpala\Zed\WebUiSettingsCustomerConnector\WebUiSettingsCustomerConnectorDependencyProvider;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \FondOfImpala\Zed\WebUiSettingsCustomerConnector\Persistence\WebUiSettingsCustomerConnectorRepositoryInterface getRepository()
 */
class WebUiSettingsCustomerConnectorBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfImpala\Zed\WebUiSettingsCustomerConnector\Business\Manager\WebUiSettingsManagerInterface
     */
    public function createWebUiSettingsManager(): WebUiSettingsManagerInterface
    {
        return new WebUiSettingsManager(
            $this->getWebUiSettingsFacade(),
            $this->getRepository(),
        );
    }

    /**
     * @return \FondOfImpala\Zed\WebUiSettingsCustomerConnector\Dependency\Facade\WebUiSettingsCustomerConnectorToWebUiSettingsFacadeInterface
     */
    protected function getWebUiSettingsFacade(): WebUiSettingsCustomerConnectorToWebUiSettingsFacadeInterface
    {
        return $this->getProvidedDependency(WebUiSettingsCustomerConnectorDependencyProvider::FACADE_WEB_UI_SETTINGS);
    }
}
