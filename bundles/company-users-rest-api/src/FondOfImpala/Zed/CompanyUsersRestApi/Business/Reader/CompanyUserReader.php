<?php

declare(strict_types = 1);

namespace FondOfImpala\Zed\CompanyUsersRestApi\Business\Reader;

use FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserReferenceFacadeInterface;
use FondOfImpala\Zed\CompanyUsersRestApi\Persistence\CompanyUsersRestApiRepositoryInterface;
use Generated\Shared\Transfer\CompanyUserCriteriaFilterTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\RestDeleteCompanyUserRequestTransfer;
use Generated\Shared\Transfer\RestWriteCompanyUserRequestTransfer;

class CompanyUserReader implements CompanyUserReaderInterface
{
    protected CompanyUsersRestApiToCompanyUserReferenceFacadeInterface $companyUserReferenceFacade;

    protected CompanyUsersRestApiRepositoryInterface $repository;

    /**
     * @param \FondOfImpala\Zed\CompanyUsersRestApi\Dependency\Facade\CompanyUsersRestApiToCompanyUserReferenceFacadeInterface $companyUserReferenceFacade
     * @param \FondOfImpala\Zed\CompanyUsersRestApi\Persistence\CompanyUsersRestApiRepositoryInterface $repository
     */
    public function __construct(
        CompanyUsersRestApiToCompanyUserReferenceFacadeInterface $companyUserReferenceFacade,
        CompanyUsersRestApiRepositoryInterface $repository
    ) {
        $this->companyUserReferenceFacade = $companyUserReferenceFacade;
        $this->repository = $repository;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return bool
     */
    public function doesCompanyUserAlreadyExist(CompanyUserTransfer $companyUserTransfer): bool
    {
        if (
            $companyUserTransfer->getFkCustomer() === null ||
            $companyUserTransfer->getFkCompany() === null ||
            $companyUserTransfer->getFkCompanyBusinessUnit() === null
        ) {
            return false;
        }

        $companyUserCriteriaFilterTransfer = (new CompanyUserCriteriaFilterTransfer())
            ->setIdCustomer($companyUserTransfer->getFkCustomer())
            ->setIdCompany($companyUserTransfer->getFkCompany())
            ->setIdCompanyBusinessUnit($companyUserTransfer->getFkCompanyBusinessUnit());

        $companyUserCollection = $this->repository
            ->findCompanyUsersByFilter($companyUserCriteriaFilterTransfer);

        return $companyUserCollection->getCompanyUsers()->count() > 0;
    }

    /**
     * @param int $idCustomer
     * @param int $idCompany
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer|null
     */
    public function getByIdCustomerAndIdCompany(int $idCustomer, int $idCompany): ?CompanyUserTransfer
    {
        $companyUserCriteriaFilterTransfer = (new CompanyUserCriteriaFilterTransfer())
            ->setIdCustomer($idCustomer)
            ->setIdCompany($idCompany);

        $companyUserCollection = $this->repository
            ->findCompanyUsersByFilter($companyUserCriteriaFilterTransfer);

        if ($companyUserCollection->getCompanyUsers()->count() !== 1) {
            return null;
        }

        return $companyUserCollection->getCompanyUsers()
            ->offsetGet(0);
    }

    /**
     * @param \Generated\Shared\Transfer\RestDeleteCompanyUserRequestTransfer $restDeleteCompanyUserRequestTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer|null
     */
    public function getCurrentByRestDeleteCompanyUserRequest(
        RestDeleteCompanyUserRequestTransfer $restDeleteCompanyUserRequestTransfer
    ): ?CompanyUserTransfer {
        $idCustomer = $restDeleteCompanyUserRequestTransfer->getIdCustomer();
        $companyUserReferenceToDelete = $restDeleteCompanyUserRequestTransfer->getCompanyUserReferenceToDelete();

        if ($idCustomer === null || $companyUserReferenceToDelete === null) {
            return null;
        }

        return $this->repository->findCompanyUserByIdCustomerAndForeignCompanyUserReference(
            $idCustomer,
            $companyUserReferenceToDelete,
        );
    }

    /**
     * @param \Generated\Shared\Transfer\RestWriteCompanyUserRequestTransfer $restWriteCompanyUserRequestTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer|null
     */
    public function getCurrentByRestWriteCompanyUserRequest(
        RestWriteCompanyUserRequestTransfer $restWriteCompanyUserRequestTransfer
    ): ?CompanyUserTransfer {
        $idCustomer = $restWriteCompanyUserRequestTransfer->getIdCustomer();
        $writeableCompanyUserReference = $restWriteCompanyUserRequestTransfer->getWriteableCompanyUserReference();

        if ($idCustomer === null || $writeableCompanyUserReference === null) {
            return null;
        }

        return $this->repository->findCompanyUserByIdCustomerAndForeignCompanyUserReference(
            $idCustomer,
            $writeableCompanyUserReference,
        );
    }

    /**
     * @param \Generated\Shared\Transfer\RestDeleteCompanyUserRequestTransfer $restDeleteCompanyUserRequestTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer|null
     */
    public function getDeletableByRestDeleteCompanyUserRequest(
        RestDeleteCompanyUserRequestTransfer $restDeleteCompanyUserRequestTransfer
    ): ?CompanyUserTransfer {
        $companyUserReferenceToDelete = $restDeleteCompanyUserRequestTransfer->getCompanyUserReferenceToDelete();

        if ($companyUserReferenceToDelete === null) {
            return null;
        }

        return $this->getByCompanyUserReference($companyUserReferenceToDelete);
    }

    /**
     * @param \Generated\Shared\Transfer\RestWriteCompanyUserRequestTransfer $restWriteCompanyUserRequestTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer|null
     */
    public function getWriteableByRestWriteCompanyUserRequest(
        RestWriteCompanyUserRequestTransfer $restWriteCompanyUserRequestTransfer
    ): ?CompanyUserTransfer {
        $writeableCompanyUserReference = $restWriteCompanyUserRequestTransfer->getWriteableCompanyUserReference();

        if ($writeableCompanyUserReference === null) {
            return null;
        }

        return $this->getByCompanyUserReference($writeableCompanyUserReference);
    }

    /**
     * @param string $companyUserReference
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer|null
     */
    public function getByCompanyUserReference(string $companyUserReference): ?CompanyUserTransfer
    {
        $companyUserTransfer = (new CompanyUserTransfer())
            ->setCompanyUserReference($companyUserReference);

        $companyUserResponseTransfer = $this->companyUserReferenceFacade->findCompanyUserByCompanyUserReference(
            $companyUserTransfer,
        );

        $companyUserTransfer = $companyUserResponseTransfer->getCompanyUser();

        if ($companyUserTransfer === null || !$companyUserResponseTransfer->getIsSuccessful()) {
            return null;
        }

        return $companyUserTransfer;
    }
}
