<?php

namespace FondOfImpala\Glue\CustomerAppRestApi\Processor\CustomerApp;

use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\RestCustomerAppRequestAttributesTransfer;
use Generated\Shared\Transfer\RestCustomerAppResponseAttributesTransfer;
use JsonException;

class CustomerAppMapper implements CustomerAppMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     * @param \Generated\Shared\Transfer\RestCustomerAppRequestAttributesTransfer $restCustomerAppRequestAttributesTransfer
     *
     * @throws \JsonException
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    public function mapRestCustomerAppRequestAttributesTransferToCustomerTransfer(
        CustomerTransfer $customerTransfer,
        RestCustomerAppRequestAttributesTransfer $restCustomerAppRequestAttributesTransfer
    ): CustomerTransfer {
        $data = $restCustomerAppRequestAttributesTransfer->getAppSettingsData();

        try {
            $customerTransfer->setAppSettings(json_encode($data, JSON_THROW_ON_ERROR));
            $customerTransfer->setAppSettingsData($data);
        } catch (JsonException $e) {
            throw $e;
        }

        return $customerTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\RestCustomerAppResponseAttributesTransfer
     */
    public function mapCustomerTransferToRestCustomerAppResponseAttributesTransfer(
        CustomerTransfer $customerTransfer
    ): RestCustomerAppResponseAttributesTransfer {
        $restCustomerAppResponseAttributesTransfer = new RestCustomerAppResponseAttributesTransfer();

        $appSettings = $customerTransfer->getAppSettings();

        if ($appSettings === null || $appSettings === '') {
            return $restCustomerAppResponseAttributesTransfer;
        }

        try {
            $data = json_decode($appSettings, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            $data = [];
        }

        return $restCustomerAppResponseAttributesTransfer->setAppSettingsData($data);
    }
}
