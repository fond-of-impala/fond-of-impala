<?php

namespace FondOfImpala\Zed\CompanyUsersRestApi\Business\Writer;

use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer;
use Generated\Shared\Transfer\RestCustomerTransfer;

interface CustomerWriterInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestCustomerTransfer $restCustomerTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer|null
     */
    public function createByRestCustomer(RestCustomerTransfer $restCustomerTransfer): ?CustomerTransfer;

    /**
     * @param \Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer|null
     */
    public function createByRestCompanyUsersRequestAttributes(
        RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
    ): ?CustomerTransfer;
}
