<?php

namespace FondOfImpala\Glue\CustomerAppRestApi\Processor\CustomerApp;

use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\RestCustomerAppRequestAttributesTransfer;
use Generated\Shared\Transfer\RestCustomerAppResponseAttributesTransfer;

interface CustomerAppMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     * @param \Generated\Shared\Transfer\RestCustomerAppRequestAttributesTransfer $restCustomerAppRequestAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    public function mapRestCustomerAppRequestAttributesTransferToCustomerTransfer(
        CustomerTransfer $customerTransfer,
        RestCustomerAppRequestAttributesTransfer $restCustomerAppRequestAttributesTransfer
    ): CustomerTransfer;

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\RestCustomerAppResponseAttributesTransfer
     */
    public function mapCustomerTransferToRestCustomerAppResponseAttributesTransfer(
        CustomerTransfer $customerTransfer
    ): RestCustomerAppResponseAttributesTransfer;
}
