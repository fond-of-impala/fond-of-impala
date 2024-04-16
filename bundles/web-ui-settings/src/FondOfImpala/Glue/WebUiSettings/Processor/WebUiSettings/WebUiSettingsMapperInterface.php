<?php

namespace FondOfImpala\Glue\WebUiSettings\Processor\WebUiSettings;

use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\RestWebUiSettingsRequestAttributesTransfer;
use Generated\Shared\Transfer\RestWebUiSettingsResponseAttributesTransfer;

interface WebUiSettingsMapperInterface
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
    ): CustomerTransfer;

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\RestWebUiSettingsResponseAttributesTransfer
     */
    public function mapCustomerTransferToRestWebUiSettingsResponseAttributesTransfer(
        CustomerTransfer $customerTransfer
    ): RestWebUiSettingsResponseAttributesTransfer;
}
