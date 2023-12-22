<?php

namespace FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Reader;

use FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Mapper\CompanyRoleNameMapperInterface;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyTypeFacadeInterface;
use FondOfImpala\Zed\CompanyUserCompanyAssigner\Persistence\CompanyUserCompanyAssignerRepositoryInterface;
use Generated\Shared\Transfer\CompanyUserTransfer;

class CompanyUserReader implements CompanyUserReaderInterface
{
    protected CompanyRoleNameMapperInterface $companyRoleNameMapper;

    protected CompanyUserCompanyAssignerToCompanyTypeFacadeInterface $companyTypeFacade;

    protected CompanyUserCompanyAssignerRepositoryInterface $repository;

    /**
     * @param \FondOfImpala\Zed\CompanyUserCompanyAssigner\Business\Mapper\CompanyRoleNameMapperInterface $companyRoleNameMapper
     * @param \FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade\CompanyUserCompanyAssignerToCompanyTypeFacadeInterface $companyTypeFacade
     * @param \FondOfImpala\Zed\CompanyUserCompanyAssigner\Persistence\CompanyUserCompanyAssignerRepositoryInterface $repository
     */
    public function __construct(
        CompanyRoleNameMapperInterface $companyRoleNameMapper,
        CompanyUserCompanyAssignerToCompanyTypeFacadeInterface $companyTypeFacade,
        CompanyUserCompanyAssignerRepositoryInterface $repository
    ) {
        $this->companyRoleNameMapper = $companyRoleNameMapper;
        $this->repository = $repository;
        $this->companyTypeFacade = $companyTypeFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $manufacturerUserTransfer
     *
     * @return array<int, array<string, mixed>>
     */
    public function findWithInconsistentCompanyRolesByManufacturerUser(
        CompanyUserTransfer $manufacturerUserTransfer
    ): array {
        $idCustomer = $manufacturerUserTransfer->getFkCustomer();
        $companyRoleName = $this->companyRoleNameMapper->fromManufacturerUser($manufacturerUserTransfer);

        if ($idCustomer === null || $companyRoleName === null) {
            return [];
        }

        $companyTypeTransfer = $this->companyTypeFacade->getManufacturerCompanyType();

        if ($companyTypeTransfer === null || $companyTypeTransfer->getIdCompanyType() === null) {
            return [];
        }

        $companyIds = $this->repository->findCompanyIdsByIdCustomerAndIdCompanyType(
            $idCustomer,
            $companyTypeTransfer->getIdCompanyType(),
        );

        if (count($companyIds) === 0) {
            return [];
        }

        return $this->repository->findNonManufacturerUsersWithInconsistentCompanyRoles(
            $idCustomer,
            $companyRoleName,
            $companyIds,
        );
    }
}
