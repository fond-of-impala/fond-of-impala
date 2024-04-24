<?php

namespace FondOfImpala\Zed\WebUiSettingsCustomerConnector\Business;

use Generated\Shared\Transfer\CustomerTransfer;

interface WebUiSettingsCustomerConnectorFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    public function handleWebUiSettings(CustomerTransfer $customerTransfer): CustomerTransfer;
}
