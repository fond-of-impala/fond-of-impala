<?php

namespace FondOfImpala\Zed\WebUiSettings\Business;

use Generated\Shared\Transfer\WebUiSettingsTransfer;

interface WebUiSettingsFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\WebUiSettingsTransfer $webUiSettingsTransfer
     *
     * @return \Generated\Shared\Transfer\WebUiSettingsTransfer
     */
    public function handleWebUiSettings(WebUiSettingsTransfer $webUiSettingsTransfer): WebUiSettingsTransfer;
}
