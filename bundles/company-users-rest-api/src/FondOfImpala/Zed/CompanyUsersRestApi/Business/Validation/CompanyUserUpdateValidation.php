<?php

namespace FondOfImpala\Zed\CompanyUsersRestApi\Business\Validation;

use Exception;
use FondOfImpala\Zed\CompanyUsersRestApi\CompanyUsersRestApiConfig;
use FondOfImpala\Zed\CompanyUsersRestApi\Persistence\CompanyUsersRestApiRepositoryInterface;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\RestWriteCompanyUserRequestTransfer;
use Orm\Zed\CompanyRole\Persistence\Map\SpyCompanyRoleTableMap;
use Orm\Zed\CompanyRole\Persistence\Map\SpyCompanyRoleToCompanyUserTableMap;

class CompanyUserUpdateValidation implements CompanyUserUpdateValidationInterface
{
    protected CompanyUsersRestApiRepositoryInterface $repository;

    protected CompanyUsersRestApiConfig $config;

    /**
     * @param \FondOfImpala\Zed\CompanyUsersRestApi\Persistence\CompanyUsersRestApiRepositoryInterface $repository
     * @param \FondOfImpala\Zed\CompanyUsersRestApi\CompanyUsersRestApiConfig $config
     */
    public function __construct(CompanyUsersRestApiRepositoryInterface $repository, CompanyUsersRestApiConfig $config)
    {
        $this->repository = $repository;
        $this->config = $config;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     * @param \Generated\Shared\Transfer\RestWriteCompanyUserRequestTransfer $restWriteCompanyUserRequestTransfer
     *
     * @return bool
     */
    public function validate(
        CompanyUserTransfer $companyUserTransfer,
        RestWriteCompanyUserRequestTransfer $restWriteCompanyUserRequestTransfer
    ): bool {
        $companyUserCollection = $this->repository->findCompanyUserByFkCompany($companyUserTransfer->getFkCompany());

        if (count($companyUserCollection->getCompanyUsers()) <= 1) {
            return false;
        }

        $roleData = $this->repository->findCompanyUserRolesByFkCompany($companyUserTransfer->getFkCompany());
        $resolvedRoleCounts = $this->getProtectedRoleCountUsage($roleData);
        $roleBeforeUpdate = $this->getCurrentRole($companyUserTransfer->getIdCompanyUser(), $roleData);

        if (array_key_exists($roleBeforeUpdate, $resolvedRoleCounts) && $resolvedRoleCounts[$roleBeforeUpdate] <= 1) {
            return false;
        }

        return true;
    }

    /**
     * @param int $idCompanyUser
     * @param array<int, array<string, mixed>> $roleData
     *
     * @throws \Exception
     *
     * @return string
     */
    protected function getCurrentRole(int $idCompanyUser, array $roleData): string
    {
        foreach ($roleData as $data) {
            if (!array_key_exists(SpyCompanyRoleToCompanyUserTableMap::COL_FK_COMPANY_USER, $data) || $data[SpyCompanyRoleToCompanyUserTableMap::COL_FK_COMPANY_USER] !== $idCompanyUser) {
                continue;
            }

            return $data[SpyCompanyRoleTableMap::COL_NAME];
        }

        throw new Exception(sprintf('Could not resolve role before update of company user with id "%s"', $idCompanyUser));
    }

    /**
     * @param array<int, array<string, mixed>> $roles
     *
     * @return array<string, int>
     */
    protected function getProtectedRoleCountUsage(array $roles): array
    {
        $protectedRoles = $this->config->getProtectedRoles();
        $counts = [];

        if (count($protectedRoles) === 0) {
            return $counts;
        }

        foreach ($roles as $role) {
            if (!in_array($role[SpyCompanyRoleTableMap::COL_NAME], $protectedRoles, true)) {
                continue;
            }
            $role = $role[SpyCompanyRoleTableMap::COL_NAME];
            if (array_key_exists($role, $counts)) {
                $counts[$role] += 1;

                continue;
            }

            $counts[$role] = 1;
        }

        return $counts;
    }
}
