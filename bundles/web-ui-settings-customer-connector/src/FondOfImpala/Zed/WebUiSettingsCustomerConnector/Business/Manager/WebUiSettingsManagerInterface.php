<?php

namespace FondOfImpala\Zed\WebUiSettingsCustomerConnector\Business\Manager;

use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\WebUiSettingsTransfer;

interface WebUiSettingsManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     * @param \Generated\Shared\Transfer\WebUiSettingsTransfer|null $webUiSettingsTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    public function handleCustomerWebUiSettings(
        CustomerTransfer $customerTransfer,
        ?WebUiSettingsTransfer $webUiSettingsTransfer = null
    ): CustomerTransfer;
}
