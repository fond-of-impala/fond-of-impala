<?php

namespace FondOfImpala\Zed\CompanyTypeRole\Business;

use Generated\Shared\Transfer\AssignableCompanyRoleCriteriaFilterTransfer;
use Generated\Shared\Transfer\CompanyResponseTransfer;
use Generated\Shared\Transfer\CompanyRoleCollectionTransfer;
use Generated\Shared\Transfer\CompanyRoleResponseTransfer;
use Generated\Shared\Transfer\CompanyRoleTransfer;
use Generated\Shared\Transfer\CompanyTypeTransfer;
use Generated\Shared\Transfer\EventEntityTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfImpala\Zed\CompanyTypeRole\Business\CompanyTypeRoleBusinessFactory getFactory()
 * @method \FondOfImpala\Zed\CompanyTypeRole\Persistence\CompanyTypeRoleRepositoryInterface getRepository()
 */
class CompanyTypeRoleFacade extends AbstractFacade implements CompanyTypeRoleFacadeInterface
{
    /**
     * {@inheritDoc}
     *
     * @param \Generated\Shared\Transfer\CompanyResponseTransfer $companyResponseTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyResponseTransfer
     * @api
     *
     */
    public function assignPredefinedCompanyRolesToNewCompany(
        CompanyResponseTransfer $companyResponseTransfer
    ): CompanyResponseTransfer
    {
        return $this->getFactory()->createCompanyRoleAssigner()
            ->assignPredefinedCompanyRolesToNewCompany($companyResponseTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @param \Generated\Shared\Transfer\EventEntityTransfer $transfer
     *
     * @return bool
     * @api
     *
     */
    public function validateCompanyTypeRoleForExport(EventEntityTransfer $transfer): bool
    {
        return $this->getFactory()
            ->createCompanyTypeRoleExportValidator()
            ->validate($transfer);
    }

    /**
     * {@inheritDoc}
     *
     * @param \Generated\Shared\Transfer\CompanyTypeTransfer $companyTypeTransfer
     * @param \Generated\Shared\Transfer\CompanyRoleTransfer $companyRoleTransfer
     *
     * @return array<string>
     * @api
     *
     */
    public function getPermissionKeysByCompanyTypeAndCompanyRole(
        CompanyTypeTransfer $companyTypeTransfer,
        CompanyRoleTransfer $companyRoleTransfer
    ): array
    {
        return $this->getFactory()
            ->createPermissionReader()
            ->getCompanyTypeRolePermissionKeys($companyTypeTransfer, $companyRoleTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @return void
     * @api
     *
     */
    public function syncPermissions(): void
    {
        $this->getFactory()->createPermissionSynchronizer()->sync();
    }

    /**
     * {@inheritDoc}
     *
     * @return void
     * @api
     *
     */
    public function syncCompanyRoles(): void
    {
        $this->getFactory()->createCompanyRoleSynchronizer()->sync();
    }

    /**
     * {@inheritDoc}
     *
     * @param \Generated\Shared\Transfer\AssignableCompanyRoleCriteriaFilterTransfer $assignableCompanyRoleCriteriaFilterTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyRoleCollectionTransfer
     * @api
     *
     */
    public function getAssignableCompanyRoles(
        AssignableCompanyRoleCriteriaFilterTransfer $assignableCompanyRoleCriteriaFilterTransfer
    ): CompanyRoleCollectionTransfer
    {
        return $this->getFactory()->createAssignableCompanyRoleReader()->getByAssignableCompanyRoleCriteriaFilter(
            $assignableCompanyRoleCriteriaFilterTransfer,
        );
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyRoleTransfer $companyRoleTransfer
     * @return \Generated\Shared\Transfer\CompanyRoleResponseTransfer
     */
    public function deleteCompanyRoleAndCompanyUserByCompanyRole(CompanyRoleTransfer $companyRoleTransfer): CompanyRoleResponseTransfer
    {
        return $this->getFactory()->createCompanyRoleDeleter()->deleteCompanyRoleAndCompanyUserByCompanyRole(
            $companyRoleTransfer,
        );
    }
}
