<?php

namespace FondOfImpala\Zed\CompanyTypeRole\Business\Model;

use FondOfImpala\Zed\CompanyTypeRole\CompanyTypeRoleConfig;
use FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyRoleFacadeInterface;
use FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyTypeFacadeInterface;
use FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToPermissionFacadeInterface;
use Generated\Shared\Transfer\CompanyResponseTransfer;
use Generated\Shared\Transfer\CompanyRoleResponseTransfer;
use Generated\Shared\Transfer\CompanyRoleTransfer;
use Generated\Shared\Transfer\CompanyTypeTransfer;
use Generated\Shared\Transfer\PermissionCollectionTransfer;

class CompanyRoleAssigner implements CompanyRoleAssignerInterface
{
    /**
     * @var \FondOfImpala\Zed\CompanyTypeRole\CompanyTypeRoleConfig
     */
    protected $companyTypeRoleConfig;

    /**
     * @var \FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyRoleFacadeInterface
     */
    protected $companyRoleFacade;

    /**
     * @var \FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyTypeFacadeInterface
     */
    protected $companyTypeFacade;

    /**
     * @var \FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToPermissionFacadeInterface
     */
    protected $permissionFacade;

    /**
     * @param \FondOfImpala\Zed\CompanyTypeRole\CompanyTypeRoleConfig $companyTypeRoleConfig
     * @param \FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyRoleFacadeInterface $companyRoleFacade
     * @param \FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyTypeFacadeInterface $companyTypeFacade
     * @param \FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToPermissionFacadeInterface $permissionFacade
     */
    public function __construct(
        CompanyTypeRoleConfig $companyTypeRoleConfig,
        CompanyTypeRoleToCompanyRoleFacadeInterface $companyRoleFacade,
        CompanyTypeRoleToCompanyTypeFacadeInterface $companyTypeFacade,
        CompanyTypeRoleToPermissionFacadeInterface $permissionFacade
    ) {
        $this->companyTypeRoleConfig = $companyTypeRoleConfig;
        $this->companyRoleFacade = $companyRoleFacade;
        $this->companyTypeFacade = $companyTypeFacade;
        $this->permissionFacade = $permissionFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyResponseTransfer $companyResponseTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyResponseTransfer
     */
    public function assignPredefinedCompanyRolesToNewCompany(
        CompanyResponseTransfer $companyResponseTransfer
    ): CompanyResponseTransfer {
        $predefinedCompanyRoles = $this->getPredefinedCompanyRolesByCompanyResponseTransfer(
            $companyResponseTransfer,
        );

        if (count($predefinedCompanyRoles) === 0) {
            return $companyResponseTransfer;
        }

        $availablePermissions = $this->permissionFacade->findMergedRegisteredNonInfrastructuralPermissions();

        foreach ($predefinedCompanyRoles as $predefinedCompanyRole) {
            $companyRoleResponseTransfer = $this->createInitialCompanyRoleWithAssignedPermissions(
                $predefinedCompanyRole,
                $companyResponseTransfer,
                $availablePermissions,
            );

            $companyResponseTransfer = $this->addCompanyRoleMessagesToCompanyResponseTransfer(
                $companyRoleResponseTransfer,
                $companyResponseTransfer,
            );
        }

        return $companyResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyResponseTransfer $companyResponseTransfer
     *
     * @return array<\Generated\Shared\Transfer\CompanyRoleTransfer>
     */
    protected function getPredefinedCompanyRolesByCompanyResponseTransfer(
        CompanyResponseTransfer $companyResponseTransfer
    ): array {
        $companyTransfer = $companyResponseTransfer->getCompanyTransfer();

        if ($companyTransfer === null) {
            return [];
        }

        $companyTypeTransfer = $companyTransfer->getCompanyType();

        if ($companyTypeTransfer !== null && $companyTypeTransfer->getName() !== null) {
            return $this->companyTypeRoleConfig
                ->getPredefinedCompanyRolesByCompanyTypeName($companyTypeTransfer->getName());
        }

        $companyTypeTransfer = (new CompanyTypeTransfer())
            ->setIdCompanyType($companyTransfer->getFkCompanyType());

        $companyTypeTransfer = $this->companyTypeFacade->getCompanyTypeById($companyTypeTransfer);

        if ($companyTypeTransfer === null || $companyTypeTransfer->getName() === null) {
            return [];
        }

        return $this->companyTypeRoleConfig
            ->getPredefinedCompanyRolesByCompanyTypeName($companyTypeTransfer->getName());
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyRoleResponseTransfer $companyRoleResponseTransfer
     * @param \Generated\Shared\Transfer\CompanyResponseTransfer $companyResponseTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyResponseTransfer
     */
    protected function addCompanyRoleMessagesToCompanyResponseTransfer(
        CompanyRoleResponseTransfer $companyRoleResponseTransfer,
        CompanyResponseTransfer $companyResponseTransfer
    ): CompanyResponseTransfer {
        foreach ($companyRoleResponseTransfer->getMessages() as $messageTransfer) {
            $companyResponseTransfer->addMessage($messageTransfer);
        }

        return $companyResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyRoleTransfer $companyRoleTransfer
     * @param \Generated\Shared\Transfer\CompanyResponseTransfer $companyResponseTransfer
     * @param \Generated\Shared\Transfer\PermissionCollectionTransfer $availablePermissions
     *
     * @return \Generated\Shared\Transfer\CompanyRoleResponseTransfer
     */
    protected function createInitialCompanyRoleWithAssignedPermissions(
        CompanyRoleTransfer $companyRoleTransfer,
        CompanyResponseTransfer $companyResponseTransfer,
        PermissionCollectionTransfer $availablePermissions
    ): CompanyRoleResponseTransfer {
        $companyTransfer = $companyResponseTransfer->getCompanyTransfer();

        if ($companyTransfer !== null) {
            $companyRoleTransfer->setFkCompany($companyTransfer->getIdCompany());
        }

        $preparedPermissionCollection = $this->findAssignedCompanyRolePermissions(
            $companyRoleTransfer->getPermissionCollection(),
            $availablePermissions,
        );

        $companyRoleTransfer->setPermissionCollection($preparedPermissionCollection);

        return $this->companyRoleFacade->create($companyRoleTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\PermissionCollectionTransfer $companyRolePermissions
     * @param \Generated\Shared\Transfer\PermissionCollectionTransfer $availablePermissions
     *
     * @return \Generated\Shared\Transfer\PermissionCollectionTransfer
     */
    protected function findAssignedCompanyRolePermissions(
        PermissionCollectionTransfer $companyRolePermissions,
        PermissionCollectionTransfer $availablePermissions
    ): PermissionCollectionTransfer {
        $availableCompanyRolePermissions = new PermissionCollectionTransfer();

        foreach ($companyRolePermissions->getPermissions() as $assignedCompanyRolePermissionTransfer) {
            foreach ($availablePermissions->getPermissions() as $availablePermissionTransfer) {
                if ($assignedCompanyRolePermissionTransfer->getKey() === $availablePermissionTransfer->getKey()) {
                    $availableCompanyRolePermissions->addPermission($availablePermissionTransfer);
                }
            }
        }

        return $availableCompanyRolePermissions;
    }
}
