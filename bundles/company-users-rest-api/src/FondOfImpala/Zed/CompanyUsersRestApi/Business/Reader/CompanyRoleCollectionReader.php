<?php

namespace FondOfImpala\Zed\CompanyUsersRestApi\Business\Reader;

use FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyRoleFacadeInterface;
use Generated\Shared\Transfer\CompanyRoleCollectionTransfer;
use Generated\Shared\Transfer\CompanyRoleTransfer;
use Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer;
use Generated\Shared\Transfer\RestWriteCompanyUserRequestTransfer;

class CompanyRoleCollectionReader implements CompanyRoleCollectionReaderInterface
{
    /**
     * @var \FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyRoleFacadeInterface
     */
    protected $companyRoleFacade;

    /**
     * @param \FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyRoleFacadeInterface $companyRoleFacade
     */
    public function __construct(CompanyUsersRestApiToCompanyRoleFacadeInterface $companyRoleFacade)
    {
        $this->companyRoleFacade = $companyRoleFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\RestWriteCompanyUserRequestTransfer $restWriteCompanyUserRequestTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyRoleCollectionTransfer|null
     */
    public function getByRestWriteCompanyUserRequest(
        RestWriteCompanyUserRequestTransfer $restWriteCompanyUserRequestTransfer
    ): ?CompanyRoleCollectionTransfer {
        $restCompanyUsersRequestAttributesTransfer = $restWriteCompanyUserRequestTransfer->getRestCompanyUsersRequestAttributes();

        if ($restCompanyUsersRequestAttributesTransfer === null) {
            return null;
        }

        return $this->getByRestCompanyUsersRequestAttributes($restCompanyUsersRequestAttributesTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyRoleCollectionTransfer|null
     */
    public function getByRestCompanyUsersRequestAttributes(
        RestCompanyUsersRequestAttributesTransfer $restCompanyUsersRequestAttributesTransfer
    ): ?CompanyRoleCollectionTransfer {
        $restCompanyRoleTransfer = $restCompanyUsersRequestAttributesTransfer->getCompanyRole();

        if ($restCompanyRoleTransfer === null || $restCompanyRoleTransfer->getUuid() === null) {
            return null;
        }

        $companyRoleTransfer = (new CompanyRoleTransfer())
            ->setUuid($restCompanyRoleTransfer->getUuid());

        $companyRoleResponseTransfer = $this->companyRoleFacade->findCompanyRoleByUuid($companyRoleTransfer);
        $companyRoleTransfer = $companyRoleResponseTransfer->getCompanyRoleTransfer();

        if ($companyRoleTransfer === null || $companyRoleResponseTransfer->getIsSuccessful() !== true) {
            return null;
        }

        return (new CompanyRoleCollectionTransfer())->addRole($companyRoleTransfer);
    }
}
