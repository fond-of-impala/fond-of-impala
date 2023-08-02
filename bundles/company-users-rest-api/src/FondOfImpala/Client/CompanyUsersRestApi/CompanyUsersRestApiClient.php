<?php

declare(strict_types = 1);

namespace FondOfImpala\Client\CompanyUsersRestApi;

use Generated\Shared\Transfer\CompanyUserCollectionTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer;
use Generated\Shared\Transfer\RestCompanyUsersResponseTransfer;
use Generated\Shared\Transfer\RestDeleteCompanyUserRequestTransfer;
use Generated\Shared\Transfer\RestDeleteCompanyUserResponseTransfer;
use Generated\Shared\Transfer\RestWriteCompanyUserRequestTransfer;
use Generated\Shared\Transfer\RestWriteCompanyUserResponseTransfer;
use Spryker\Client\Kernel\AbstractClient;

/**
 * @method \FondOfImpala\Client\CompanyUsersRestApi\CompanyUsersRestApiFactory getFactory()
 */
class CompanyUsersRestApiClient extends AbstractClient implements CompanyUsersRestApiClientInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\RestCompanyUsersResponseTransfer
     */
    public function create(
        RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
    ): RestCompanyUsersResponseTransfer {
        return $this->getFactory()
            ->createZedCompanyUsersRestApiStub()
            ->create($restCompanyUsersRequestAttributesTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserCollectionTransfer
     */
    public function findActiveCompanyUsersByCustomerReference(
        CustomerTransfer $customerTransfer
    ): CompanyUserCollectionTransfer {
        return $this->getFactory()
            ->createZedCompanyUsersRestApiStub()
            ->findActiveCompanyUsersByCustomerReference($customerTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\RestDeleteCompanyUserRequestTransfer $restDeleteCompanyUserRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestDeleteCompanyUserResponseTransfer
     */
    public function deleteCompanyUserByRestDeleteCompanyUserRequest(
        RestDeleteCompanyUserRequestTransfer $restDeleteCompanyUserRequestTransfer
    ): RestDeleteCompanyUserResponseTransfer {
        return $this->getFactory()
            ->createZedCompanyUsersRestApiStub()
            ->deleteCompanyUserByRestDeleteCompanyUserRequest($restDeleteCompanyUserRequestTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\RestWriteCompanyUserRequestTransfer $restWriteCompanyUserRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestWriteCompanyUserResponseTransfer
     */
    public function updateCompanyUserByRestDeleteCompanyUserRequest(
        RestWriteCompanyUserRequestTransfer $restWriteCompanyUserRequestTransfer
    ): RestWriteCompanyUserResponseTransfer {
        return $this->getFactory()
            ->createZedCompanyUsersRestApiStub()
            ->updateCompanyUserByRestWriteCompanyUserRequest($restWriteCompanyUserRequestTransfer);
    }
}
