<?php

declare(strict_types = 1);

namespace FondOfImpala\Client\CompanyUsersRestApi\Zed;

use FondOfImpala\Client\CompanyUsersRestApi\Dependency\Client\CompanyUsersRestApiToZedRequestClientInterface;
use Generated\Shared\Transfer\CompanyUserCollectionTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer;
use Generated\Shared\Transfer\RestCompanyUsersResponseTransfer;
use Generated\Shared\Transfer\RestDeleteCompanyUserRequestTransfer;
use Generated\Shared\Transfer\RestDeleteCompanyUserResponseTransfer;
use Generated\Shared\Transfer\RestWriteCompanyUserRequestTransfer;
use Generated\Shared\Transfer\RestWriteCompanyUserResponseTransfer;

class CompanyUsersRestApiStub implements CompanyUsersRestApiStubInterface
{
    /**
     * @var \FondOfImpala\Client\CompanyUsersRestApi\Dependency\Client\CompanyUsersRestApiToZedRequestClientInterface
     */
    protected $zedRequestClient;

    /**
     * @param \FondOfImpala\Client\CompanyUsersRestApi\Dependency\Client\CompanyUsersRestApiToZedRequestClientInterface $zedRequestClient
     */
    public function __construct(CompanyUsersRestApiToZedRequestClientInterface $zedRequestClient)
    {
        $this->zedRequestClient = $zedRequestClient;
    }

    /**
     * @param \Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\RestCompanyUsersResponseTransfer
     */
    public function create(
        RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
    ): RestCompanyUsersResponseTransfer {
        /** @var \Generated\Shared\Transfer\RestCompanyUsersResponseTransfer $restCompanyUsersResponseTransfer */
        $restCompanyUsersResponseTransfer = $this->zedRequestClient->call(
            '/company-users-rest-api/gateway/create',
            $restCompanyUsersRequestAttributesTransfer,
        );

        return $restCompanyUsersResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserCollectionTransfer
     */
    public function findActiveCompanyUsersByCustomerReference(
        CustomerTransfer $customerTransfer
    ): CompanyUserCollectionTransfer {
        /** @var \Generated\Shared\Transfer\CompanyUserCollectionTransfer $companyUserCollectionTransfer */
        $companyUserCollectionTransfer = $this->zedRequestClient->call(
            '/company-users-rest-api/gateway/find-active-company-users-by-customer-reference',
            $customerTransfer,
        );

        return $companyUserCollectionTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\RestDeleteCompanyUserRequestTransfer $restDeleteCompanyUserRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestDeleteCompanyUserResponseTransfer
     */
    public function deleteCompanyUserByRestDeleteCompanyUserRequest(
        RestDeleteCompanyUserRequestTransfer $restDeleteCompanyUserRequestTransfer
    ): RestDeleteCompanyUserResponseTransfer {
        /** @var \Generated\Shared\Transfer\RestDeleteCompanyUserResponseTransfer $restDeleteCompanyUserResponseTransfer */
        $restDeleteCompanyUserResponseTransfer = $this->zedRequestClient->call(
            '/company-users-rest-api/gateway/delete-company-user-by-rest-delete-company-user-request',
            $restDeleteCompanyUserRequestTransfer,
        );

        return $restDeleteCompanyUserResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\RestWriteCompanyUserRequestTransfer $restWriteCompanyUserRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestWriteCompanyUserResponseTransfer
     */
    public function updateCompanyUserByRestWriteCompanyUserRequest(
        RestWriteCompanyUserRequestTransfer $restWriteCompanyUserRequestTransfer
    ): RestWriteCompanyUserResponseTransfer {
        /** @var \Generated\Shared\Transfer\RestWriteCompanyUserResponseTransfer $restWriteCompanyUserResponseTransfer */
        $restWriteCompanyUserResponseTransfer = $this->zedRequestClient->call(
            '/company-users-rest-api/gateway/update-company-user-by-rest-write-company-user-request',
            $restWriteCompanyUserRequestTransfer,
        );

        return $restWriteCompanyUserResponseTransfer;
    }
}
