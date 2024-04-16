<?php

namespace FondOfImpala\Glue\WebUiSettings\Processor\WebUiSettings;

use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\RestWebUiSettingsRequestAttributesTransfer;
use Generated\Shared\Transfer\RestWebUiSettingsResponseAttributesTransfer;

class WebUiSettingsMapper implements WebUiSettingsMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     * @param \Generated\Shared\Transfer\RestWebUiSettingsRequestAttributesTransfer $restWebUiSettingsRequestAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    public function mapRestWebUiSettingsRequestAttributesTransferToCustomerTransfer(
        CustomerTransfer $customerTransfer,
        RestWebUiSettingsRequestAttributesTransfer $restWebUiSettingsRequestAttributesTransfer
    ): CustomerTransfer {
        return $customerTransfer->setWebUiSettings($restWebUiSettingsRequestAttributesTransfer->getWebUiSettings());
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\RestWebUiSettingsResponseAttributesTransfer
     */
    public function mapCustomerTransferToRestWebUiSettingsResponseAttributesTransfer(
        CustomerTransfer $customerTransfer
    ): RestWebUiSettingsResponseAttributesTransfer {
        $restWebUiSettingsResponseAttributesTransfer = new RestWebUiSettingsResponseAttributesTransfer();

        $webUiSettings = $customerTransfer->getWebUiSettings();

        if ($webUiSettings === null) {
            return $restWebUiSettingsResponseAttributesTransfer;
        }

        return $restWebUiSettingsResponseAttributesTransfer->setWebUiSettings($webUiSettings);
    }
}
