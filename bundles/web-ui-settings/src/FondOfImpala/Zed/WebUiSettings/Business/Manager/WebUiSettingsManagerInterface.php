<?php

namespace FondOfImpala\Zed\WebUiSettings\Business\Manager;

use Generated\Shared\Transfer\WebUiSettingsTransfer;

interface WebUiSettingsManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\WebUiSettingsTransfer $webUiSettingsTransfer
     *
     * @return \Generated\Shared\Transfer\WebUiSettingsTransfer
     */
    public function handle(WebUiSettingsTransfer $webUiSettingsTransfer): WebUiSettingsTransfer;
}
