<?php

namespace FondOfImpala\Zed\CompanyTypeRole\Business\Synchronizer;

use FondOfImpala\Zed\CompanyTypeRole\Business\Builder\CompanyRoleCriteriaFilterBuilderInterface;
use FondOfImpala\Zed\CompanyTypeRole\Business\Filter\CompanyTypeNameFilterInterface;
use FondOfImpala\Zed\CompanyTypeRole\Business\Intersection\PermissionIntersectionInterface;
use FondOfImpala\Zed\CompanyTypeRole\CompanyTypeRoleConfig;
use FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyRoleFacadeInterface;
use FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToPermissionFacadeInterface;
use Generated\Shared\Transfer\CompanyRoleCollectionTransfer;
use Generated\Shared\Transfer\PermissionCollectionTransfer;

class PermissionSynchronizer implements PermissionSynchronizerInterface
{
    /**
     * @var int
     */
    public const PAGINATION_MAX_PER_PAGE = 100;

    /**
     * @var \FondOfImpala\Zed\CompanyTypeRole\Business\Filter\CompanyTypeNameFilterInterface
     */
    protected $companyTypeNameFilter;

    /**
     * @var \FondOfImpala\Zed\CompanyTypeRole\Business\Intersection\PermissionIntersectionInterface
     */
    protected $permissionIntersection;

    /**
     * @var \FondOfImpala\Zed\CompanyTypeRole\Business\Builder\CompanyRoleCriteriaFilterBuilderInterface
     */
    protected $companyRoleCriteriaFilterBuilder;

    /**
     * @var \FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyRoleFacadeInterface
     */
    protected $companyRoleFacade;

    /**
     * @var \FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToPermissionFacadeInterface
     */
    protected $permissionFacade;

    /**
     * @var \FondOfImpala\Zed\CompanyTypeRole\CompanyTypeRoleConfig
     */
    protected $config;

    /**
     * @param \FondOfImpala\Zed\CompanyTypeRole\Business\Filter\CompanyTypeNameFilterInterface $companyTypeNameFilter
     * @param \FondOfImpala\Zed\CompanyTypeRole\Business\Intersection\PermissionIntersectionInterface $permissionIntersection
     * @param \FondOfImpala\Zed\CompanyTypeRole\Business\Builder\CompanyRoleCriteriaFilterBuilderInterface $companyRoleCriteriaFilterBuilder
     * @param \FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToCompanyRoleFacadeInterface $companyRoleFacade
     * @param \FondOfImpala\Zed\CompanyTypeRole\Dependency\Facade\CompanyTypeRoleToPermissionFacadeInterface $permissionFacade
     * @param \FondOfImpala\Zed\CompanyTypeRole\CompanyTypeRoleConfig $config
     */
    public function __construct(
        CompanyTypeNameFilterInterface $companyTypeNameFilter,
        PermissionIntersectionInterface $permissionIntersection,
        CompanyRoleCriteriaFilterBuilderInterface $companyRoleCriteriaFilterBuilder,
        CompanyTypeRoleToCompanyRoleFacadeInterface $companyRoleFacade,
        CompanyTypeRoleToPermissionFacadeInterface $permissionFacade,
        CompanyTypeRoleConfig $config
    ) {
        $this->companyTypeNameFilter = $companyTypeNameFilter;
        $this->permissionIntersection = $permissionIntersection;
        $this->companyRoleCriteriaFilterBuilder = $companyRoleCriteriaFilterBuilder;
        $this->companyRoleFacade = $companyRoleFacade;
        $this->permissionFacade = $permissionFacade;
        $this->config = $config;
    }

    /**
     * @return void
     */
    public function sync(): void
    {
        $permissionCollectionTransfer = $this->permissionFacade->findAll();

        if ($permissionCollectionTransfer->getPermissions()->count() === 0) {
            return;
        }

        $companyRoleCollectionTransfer = $this->companyRoleFacade->getCompanyRoleCollection(
            $this->companyRoleCriteriaFilterBuilder->buildByPageAndMaxPerPage(1, 1),
        );

        $paginationTransfer = $companyRoleCollectionTransfer->getPagination();

        if ($paginationTransfer === null || $paginationTransfer->getNbResults() === 0) {
            return;
        }

        $page = 1;
        $total = $paginationTransfer->getNbResults();

        while ($page <= ceil($total / static::PAGINATION_MAX_PER_PAGE)) {
            $companyRoleCollectionTransfer = $this->companyRoleFacade->getCompanyRoleCollection(
                $this->companyRoleCriteriaFilterBuilder->buildByPageAndMaxPerPage(
                    $page,
                    static::PAGINATION_MAX_PER_PAGE,
                ),
            );

            $this->syncChunk($companyRoleCollectionTransfer, $permissionCollectionTransfer);

            $page++;
        }
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyRoleCollectionTransfer $companyRoleCollectionTransfer
     * @param \Generated\Shared\Transfer\PermissionCollectionTransfer $permissionCollectionTransfer
     *
     * @return void
     */
    protected function syncChunk(
        CompanyRoleCollectionTransfer $companyRoleCollectionTransfer,
        PermissionCollectionTransfer $permissionCollectionTransfer
    ): void {
        foreach ($companyRoleCollectionTransfer->getRoles() as $companyRoleTransfer) {
            $companyRoleName = $companyRoleTransfer->getName();
            $companyTypeName = $this->companyTypeNameFilter->filterFromCompanyRole($companyRoleTransfer);

            if ($companyTypeName === null || $companyRoleName === null) {
                continue;
            }

            $permissionKeys = $this->config->getPermissionKeys($companyTypeName, $companyRoleName);

            if (count($permissionKeys) === 0) {
                continue;
            }

            $intersectedPermissionCollectionTransfer = $this->permissionIntersection->intersect(
                $permissionCollectionTransfer,
                $permissionKeys,
            );

            $companyRoleTransfer->setPermissionCollection($intersectedPermissionCollectionTransfer);

            $this->companyRoleFacade->update($companyRoleTransfer);
        }
    }
}
