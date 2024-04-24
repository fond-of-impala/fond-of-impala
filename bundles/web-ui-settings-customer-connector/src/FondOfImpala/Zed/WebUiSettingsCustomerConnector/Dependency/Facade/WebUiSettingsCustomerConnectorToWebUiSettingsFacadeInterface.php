<?php

namespace FondOfImpala\Zed\WebUiSettingsCustomerConnector\Dependency\Facade;

use Generated\Shared\Transfer\WebUiSettingsTransfer;

interface WebUiSettingsCustomerConnectorToWebUiSettingsFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\WebUiSettingsTransfer $webUiSettingsTransfer
     *
     * @return \Generated\Shared\Transfer\WebUiSettingsTransfer
     */
    public function handleWebUiSettings(WebUiSettingsTransfer $webUiSettingsTransfer): WebUiSettingsTransfer;
}
