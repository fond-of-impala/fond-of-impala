<?php

namespace FondOfImpala\Zed\WebUiSettings\Persistence;

use Generated\Shared\Transfer\WebUiSettingsTransfer;

interface WebUiSettingsEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\WebUiSettingsTransfer $webUiSettingsTransfer
     *
     * @return \Generated\Shared\Transfer\WebUiSettingsTransfer
     */
    public function updateWebUiSettingsById(WebUiSettingsTransfer $webUiSettingsTransfer): WebUiSettingsTransfer;

    /**
     * @param \Generated\Shared\Transfer\WebUiSettingsTransfer $webUiSettingsTransfer
     *
     * @return \Generated\Shared\Transfer\WebUiSettingsTransfer
     */
    public function createWebUiSettings(WebUiSettingsTransfer $webUiSettingsTransfer): WebUiSettingsTransfer;
}
