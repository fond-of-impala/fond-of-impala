<?php

declare(strict_types = 1);

namespace FondOfImpala\Zed\CompanyUsersRestApi\Business\Mapper;

use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\RestCustomerTransfer;

class CustomerMapper implements CustomerMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestCustomerTransfer $restCustomerTransfer
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    public function mapRestCustomerTransferToCustomerTransfer(
        RestCustomerTransfer $restCustomerTransfer,
        CustomerTransfer $customerTransfer
    ): CustomerTransfer {
        return $customerTransfer->fromArray($restCustomerTransfer->toArray(), true);
    }

    /**
     * @param \Generated\Shared\Transfer\RestCustomerTransfer $restCustomerTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    public function fromRestCustomer(
        RestCustomerTransfer $restCustomerTransfer
    ): CustomerTransfer {
        return (new CustomerTransfer())->fromArray($restCustomerTransfer->toArray(), true);
    }
}
