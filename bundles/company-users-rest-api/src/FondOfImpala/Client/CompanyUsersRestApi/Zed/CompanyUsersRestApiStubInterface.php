<?php

declare(strict_types = 1);

namespace FondOfImpala\Client\CompanyUsersRestApi\Zed;

use Generated\Shared\Transfer\CompanyUserCollectionTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer;
use Generated\Shared\Transfer\RestCompanyUsersResponseTransfer;
use Generated\Shared\Transfer\RestDeleteCompanyUserRequestTransfer;
use Generated\Shared\Transfer\RestDeleteCompanyUserResponseTransfer;
use Generated\Shared\Transfer\RestWriteCompanyUserRequestTransfer;
use Generated\Shared\Transfer\RestWriteCompanyUserResponseTransfer;

interface CompanyUsersRestApiStubInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\RestCompanyUsersResponseTransfer
     */
    public function create(
        RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
    ): RestCompanyUsersResponseTransfer;

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserCollectionTransfer
     */
    public function findActiveCompanyUsersByCustomerReference(
        CustomerTransfer $customerTransfer
    ): CompanyUserCollectionTransfer;

    /**
     * @param \Generated\Shared\Transfer\RestDeleteCompanyUserRequestTransfer $restDeleteCompanyUserRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestDeleteCompanyUserResponseTransfer
     */
    public function deleteCompanyUserByRestDeleteCompanyUserRequest(
        RestDeleteCompanyUserRequestTransfer $restDeleteCompanyUserRequestTransfer
    ): RestDeleteCompanyUserResponseTransfer;

    /**
     * @param \Generated\Shared\Transfer\RestWriteCompanyUserRequestTransfer $restWriteCompanyUserRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestWriteCompanyUserResponseTransfer
     */
    public function updateCompanyUserByRestWriteCompanyUserRequest(
        RestWriteCompanyUserRequestTransfer $restWriteCompanyUserRequestTransfer
    ): RestWriteCompanyUserResponseTransfer;
}
