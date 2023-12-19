<?php

namespace FondOfImpala\Zed\CompanyUserCompanyAssigner\Business;

use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Generated\Shared\Transfer\CompanyResponseTransfer;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyTypeTransfer;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\CompanyUserCompanyAssignerBusinessFactory getFactory()
 * @method \FondOfImpala\Zed\CompanyUserCompanyAssigner\Persistence\CompanyUserCompanyAssignerRepositoryInterface getRepository()
 */
class CompanyUserCompanyAssignerFacade extends AbstractFacade implements CompanyUserCompanyAssignerFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyUserResponseTransfer $companyUserResponseTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserResponseTransfer
     */
    public function addManufacturerUserToCompanies(
        CompanyUserResponseTransfer $companyUserResponseTransfer
    ): CompanyUserResponseTransfer {
        return $this->getFactory()
            ->createCompanyUser()
            ->addManufacturerUserToCompanies($companyUserResponseTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return void
     */
    public function updateCompanyRolesOfNonManufacturerUsers(
        CompanyUserTransfer $companyUserTransfer
    ): void {
        $this->getFactory()
            ->createCompanyRoleManager()
            ->updateCompanyRolesOfNonManufacturerUsers($companyUserTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyResponseTransfer $companyResponseTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyResponseTransfer
     */
    public function addManufacturerUsersToCompany(
        CompanyResponseTransfer $companyResponseTransfer
    ): CompanyResponseTransfer {
        return $this->getFactory()
            ->createCompanyUser()
            ->addManufacturerUsersToCompany($companyResponseTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitTransfer $companyBusinessUnitTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitTransfer
     */
    public function addManufacturerUsersToCompanyBusinessUnit(
        CompanyBusinessUnitTransfer $companyBusinessUnitTransfer
    ): CompanyBusinessUnitTransfer {
        return $this->getFactory()
            ->createCompanyUser()
            ->addManufacturerUsersToCompanyBusinessUnit($companyBusinessUnitTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $manufacturerUserTransfer
     *
     * @return void
     */
    public function assignManufacturerUserNonManufacturerCompanies(CompanyUserTransfer $manufacturerUserTransfer): void
    {
        $this->getFactory()
            ->createManufacturerUserAssigner()
            ->assignToNonManufacturerCompanies($manufacturerUserTransfer);
    }

    /**
     * @return \Generated\Shared\Transfer\CompanyTypeTransfer
     */
    public function getManufacturerCompanyType(): CompanyTypeTransfer
    {
        return $this->getFactory()
            ->createCompanyTypeReader()
            ->getManufacturerCompanyType();
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTypeTransfer
     */
    public function getCompanyTypeByCompany(CompanyTransfer $companyTransfer): CompanyTypeTransfer
    {
        return $this
            ->getFactory()
            ->createCompanyTypeReader()
            ->getByCompany($companyTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return array<int, array<string, mixed>>
     */
    public function findCompanyUsersWithInconsistentCompanyRolesByManufacturerUser(
        CompanyUserTransfer $companyUserTransfer
    ): array {
        return $this->getFactory()
            ->createCompanyUserReader()
            ->findWithInconsistentCompanyRolesByManufacturerUser($companyUserTransfer);
    }
}
