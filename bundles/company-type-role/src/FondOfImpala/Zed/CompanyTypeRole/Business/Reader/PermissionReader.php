<?php

namespace FondOfImpala\Zed\CompanyTypeRole\Business\Reader;

use FondOfImpala\Zed\CompanyTypeRole\Business\Intersection\PermissionIntersectionInterface;
use FondOfImpala\Zed\CompanyTypeRole\CompanyTypeRoleConfig;
use FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToPermissionFacadeInterface;
use Generated\Shared\Transfer\PermissionCollectionTransfer;
use Generated\Shared\Transfer\PermissionSetTransfer;

class PermissionReader implements PermissionReaderInterface
{
    /**
     * @var \FondOfImpala\Zed\CompanyTypeRole\Business\Intersection\PermissionIntersectionInterface
     */
    protected $permissionIntersection;

    /**
     * @var \FondOfImpala\Zed\CompanyTypeRole\CompanyTypeRoleConfig
     */
    protected $config;

    /**
     * @var \FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToPermissionFacadeInterface
     */
    protected $permissionFacade;

    /**
     * @param \FondOfImpala\Zed\CompanyTypeRole\Business\Intersection\PermissionIntersectionInterface $permissionIntersection
     * @param \FondOfImpala\Zed\CompanyTypeRole\CompanyTypeRoleConfig $config
     * @param \FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToPermissionFacadeInterface $permissionFacade
     */
    public function __construct(
        PermissionIntersectionInterface $permissionIntersection,
        CompanyTypeRoleConfig $config,
        CompanyTypeRoleToPermissionFacadeInterface $permissionFacade
    ) {
        $this->permissionIntersection = $permissionIntersection;
        $this->config = $config;
        $this->permissionFacade = $permissionFacade;
    }

    /**
     * @return \Generated\Shared\Transfer\PermissionCollectionTransfer
     */
    public function getPermissions(): PermissionCollectionTransfer
    {
        return $this->permissionFacade->findAll();
    }

    /**
     * @return array<\Generated\Shared\Transfer\PermissionSetTransfer>
     */
    public function getPermissionSets(): array
    {
        $permissionSets = [];
        $allPermissionCollectionTransfer = $this->getPermissions();
        $groupedPermissionKeys = $this->config->getGroupedPermissionKeys();

        foreach (array_keys($groupedPermissionKeys) as $companyTypeName) {
            foreach (array_keys($groupedPermissionKeys[$companyTypeName]) as $companyRoleName) {
                $permissionKeys = $groupedPermissionKeys[$companyTypeName][$companyRoleName];

                $permissionSet = (new PermissionSetTransfer())->setCompanyType($companyTypeName)
                    ->setCompanyRoleName($companyRoleName)
                    ->setEntries(
                        $this->permissionIntersection->intersect(
                            $allPermissionCollectionTransfer,
                            $permissionKeys,
                        ),
                    );

                $permissionSets[] = $permissionSet;
            }
        }

        return $permissionSets;
    }
}
