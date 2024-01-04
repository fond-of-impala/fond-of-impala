<?php

namespace FondOfImpala\Zed\NavisionCompanyUser\Business\Reader;

use FondOfImpala\Zed\NavisionCompanyUser\Persistence\NavisionCompanyUserRepositoryInterface;
use Generated\Shared\Transfer\CompanyUserResponseTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;

class CompanyUserReader implements CompanyUserReaderInterface
{
    protected NavisionCompanyUserRepositoryInterface $navisionCompanyUserRepository;

    /**
     * @param \FondOfImpala\Zed\NavisionCompanyUser\Persistence\NavisionCompanyUserRepositoryInterface $navisionCompanyUserRepository
     */
    public function __construct(NavisionCompanyUserRepositoryInterface $navisionCompanyUserRepository)
    {
        $this->navisionCompanyUserRepository = $navisionCompanyUserRepository;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUserTransfer $companyUserTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserResponseTransfer
     */
    public function findCompanyUserByExternalReference(CompanyUserTransfer $companyUserTransfer): CompanyUserResponseTransfer
    {
        $companyUserTransfer->requireExternalReference();

        $companyUserTransfer = $this->navisionCompanyUserRepository->findCompanyUserByExternalReference(
            $companyUserTransfer->getExternalReference(),
        );

        $companyUserResponseTransfer = new CompanyUserResponseTransfer();
        if (!$companyUserTransfer) {
            return $companyUserResponseTransfer->setIsSuccessful(false);
        }

        return $companyUserResponseTransfer
            ->setIsSuccessful(true)
            ->setCompanyUser($companyUserTransfer);
    }
}
