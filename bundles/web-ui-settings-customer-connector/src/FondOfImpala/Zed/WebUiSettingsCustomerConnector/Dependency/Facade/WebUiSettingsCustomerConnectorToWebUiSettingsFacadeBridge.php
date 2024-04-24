<?php

namespace FondOfImpala\Zed\WebUiSettingsCustomerConnector\Dependency\Facade;

use FondOfImpala\Zed\WebUiSettings\Business\WebUiSettingsFacadeInterface;
use Generated\Shared\Transfer\WebUiSettingsTransfer;

class WebUiSettingsCustomerConnectorToWebUiSettingsFacadeBridge implements WebUiSettingsCustomerConnectorToWebUiSettingsFacadeInterface
{
    protected WebUiSettingsFacadeInterface $facade;

    /**
     * @param \FondOfImpala\Zed\WebUiSettings\Business\WebUiSettingsFacadeInterface $webUiSettingsFacade
     */
    public function __construct(WebUiSettingsFacadeInterface $webUiSettingsFacade)
    {
        $this->facade = $webUiSettingsFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\WebUiSettingsTransfer $webUiSettingsTransfer
     *
     * @return \Generated\Shared\Transfer\WebUiSettingsTransfer
     */
    public function handleWebUiSettings(WebUiSettingsTransfer $webUiSettingsTransfer): WebUiSettingsTransfer
    {
        return $this->facade->handleWebUiSettings($webUiSettingsTransfer);
    }
}
