<?php

namespace FondOfImpala\Zed\CompanyUsersRestApi\Business\Validation;

use FondOfImpala\Zed\CompanyUsersRestApi\CompanyUsersRestApiConfig;
use FondOfImpala\Zed\CompanyUsersRestApi\Persistence\CompanyUsersRestApiRepositoryInterface;
use Generated\Shared\Transfer\CompanyUserCollectionTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\RestDeleteCompanyUserRequestTransfer;

class CompanyUserDeleteValidation implements CompanyUserDeleteValidationInterface
{
    /**
     * @var \FondOfImpala\Zed\CompanyUsersRestApi\Persistence\CompanyUsersRestApiRepositoryInterface
     */
    protected $repository;

    /**
     * @var \FondOfImpala\Zed\CompanyUsersRestApi\CompanyUsersRestApiConfig
     */
    protected $config;

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
     * @param \Generated\Shared\Transfer\RestDeleteCompanyUserRequestTransfer $restDeleteCompanyUserRequestTransfer
     *
     * @return bool
     */
    public function validate(
        CompanyUserTransfer $companyUserTransfer,
        RestDeleteCompanyUserRequestTransfer $restDeleteCompanyUserRequestTransfer
    ): bool {
        $companyUserCollection = $this->repository->findCompanyUserByFkCompany($companyUserTransfer->getFkCompany());

        if (count($companyUserCollection->getCompanyUsers()) <= 1 || $this->isProtectedByRole($companyUserTransfer)) {
            return false;
        }

        $loggedInCompanyUserTransfer = $this->resolveLoggedInCompanyUser($companyUserCollection, $restDeleteCompanyUserRequestTransfer->getIdCustomer());

        return $loggedInCompanyUserTransfer !== null && $companyUserTransfer->getFkCustomer() !== $loggedInCompanyUserTransfer->getFkCustomer();
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserCollectionTransfer $companyUserCollectionTransfer
     * @param int $idCustomer
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer|null
     */
    protected function resolveLoggedInCompanyUser(CompanyUserCollectionTransfer $companyUserCollectionTransfer, int $idCustomer): ?CompanyUserTransfer
    {
        foreach ($companyUserCollectionTransfer->getCompanyUsers() as $companyUserTransfer) {
            if ($companyUserTransfer->getFkCustomer() === $idCustomer) {
                return $companyUserTransfer;
            }
        }

        return null;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return bool
     */
    protected function isProtectedByRole(CompanyUserTransfer $companyUserTransfer): bool
    {
        $protectedRoles = $this->config->getProtectedRoles();

        if (count($protectedRoles) === 0) {
            return false;
        }

        $userRoles = $this->repository->findCompanyUserRolesByCompanyUser($companyUserTransfer);
        foreach ($userRoles as $userRole) {
            if (in_array($userRole, $protectedRoles, true)) {
                return true;
            }
        }

        return false;
    }
}
