<?php

namespace FondOfImpala\Zed\NavisionCompany\Business\Reader;

use FondOfImpala\Zed\NavisionCompany\Persistence\NavisionCompanyRepositoryInterface;
use Generated\Shared\Transfer\CompanyResponseTransfer;
use Generated\Shared\Transfer\CompanyTransfer;

class CompanyReader implements CompanyReaderInterface
{
    protected NavisionCompanyRepositoryInterface $navisionCompanyRepository;

    /**
     * @param \FondOfImpala\Zed\NavisionCompany\Persistence\NavisionCompanyRepositoryInterface $navisionCompanyRepository
     */
    public function __construct(NavisionCompanyRepositoryInterface $navisionCompanyRepository)
    {
        $this->navisionCompanyRepository = $navisionCompanyRepository;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyResponseTransfer
     */
    public function findCompanyByExternalReference(CompanyTransfer $companyTransfer): CompanyResponseTransfer
    {
        $companyTransfer->requireExternalReference();

        $companyTransfer = $this->navisionCompanyRepository->findCompanyByExternalReference(
            $companyTransfer->getExternalReference(),
        );

        $companyResponseTransfer = new CompanyResponseTransfer();
        if (!$companyTransfer) {
            return $companyResponseTransfer->setIsSuccessful(false);
        }

        return $companyResponseTransfer
            ->setIsSuccessful(true)
            ->setCompanyTransfer($companyTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyResponseTransfer
     */
    public function findCompanyByDebtorNumber(CompanyTransfer $companyTransfer): CompanyResponseTransfer
    {
        $companyTransfer->requireDebtorNumber();

        $companyTransfer = $this->navisionCompanyRepository->findCompanyByDebtorNumber(
            $companyTransfer->getDebtorNumber(),
        );

        $companyResponseTransfer = new CompanyResponseTransfer();
        if (!$companyTransfer) {
            return $companyResponseTransfer->setIsSuccessful(false);
        }

        return $companyResponseTransfer
            ->setIsSuccessful(true)
            ->setCompanyTransfer($companyTransfer);
    }
}
