<?php

namespace FondOfImpala\Zed\NavisionCompanyBusinessUnit\Business\Reader;

use FondOfImpala\Zed\NavisionCompanyBusinessUnit\Persistence\NavisionCompanyBusinessUnitRepositoryInterface;
use Generated\Shared\Transfer\CompanyBusinessUnitResponseTransfer;
use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;

class CompanyBusinessUnitReader implements CompanyBusinessUnitReaderInterface
{
    protected NavisionCompanyBusinessUnitRepositoryInterface $navisionCompanyBusinessUnitRepository;

    /**
     * @param \FondOfImpala\Zed\NavisionCompanyBusinessUnit\Persistence\NavisionCompanyBusinessUnitRepositoryInterface $navisionCompanyBusinessUnitRepository
     */
    public function __construct(NavisionCompanyBusinessUnitRepositoryInterface $navisionCompanyBusinessUnitRepository)
    {
        $this->navisionCompanyBusinessUnitRepository = $navisionCompanyBusinessUnitRepository;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitTransfer $companyBusinessUnitTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitResponseTransfer
     */
    public function findCompanyBusinessUnitByExternalReference(
        CompanyBusinessUnitTransfer $companyBusinessUnitTransfer
    ): CompanyBusinessUnitResponseTransfer {
        $companyBusinessUnitTransfer->requireExternalReference();

        $companyBusinessUnitTransfer = $this->navisionCompanyBusinessUnitRepository->findCompanyBusinessUnitByExternalReference(
            $companyBusinessUnitTransfer->getExternalReference(),
        );

        $companyBusinessUnitResponseTransfer = new CompanyBusinessUnitResponseTransfer();
        if (!$companyBusinessUnitTransfer) {
            return $companyBusinessUnitResponseTransfer->setIsSuccessful(false);
        }

        return $companyBusinessUnitResponseTransfer
            ->setIsSuccessful(true)
            ->setCompanyBusinessUnitTransfer($companyBusinessUnitTransfer);
    }
}
