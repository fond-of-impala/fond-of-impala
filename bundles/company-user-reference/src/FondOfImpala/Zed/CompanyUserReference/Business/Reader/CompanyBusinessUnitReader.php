<?php

namespace FondOfImpala\Zed\CompanyUserReference\Business\Reader;

use FondOfImpala\Zed\CompanyUserReference\Dependency\Facade\CompanyUserReferenceToCompanyBusinessUnitFacadeInterface;
use FondOfImpala\Zed\CompanyUserReference\Persistence\CompanyUserReferenceRepositoryInterface;
use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;

class CompanyBusinessUnitReader implements CompanyBusinessUnitReaderInterface
{
    /**
     * @var \FondOfImpala\Zed\CompanyUserReference\Persistence\CompanyUserReferenceRepositoryInterface
     */
    protected $repository;

    /**
     * @var \FondOfImpala\Zed\CompanyUserReference\Dependency\Facade\CompanyUserReferenceToCompanyBusinessUnitFacadeInterface
     */
    protected $companyBusinessUnitFacade;

    /**
     * @param \FondOfImpala\Zed\CompanyUserReference\Persistence\CompanyUserReferenceRepositoryInterface $repository
     * @param \FondOfImpala\Zed\CompanyUserReference\Dependency\Facade\CompanyUserReferenceToCompanyBusinessUnitFacadeInterface $companyBusinessUnitFacade
     */
    public function __construct(
        CompanyUserReferenceRepositoryInterface $repository,
        CompanyUserReferenceToCompanyBusinessUnitFacadeInterface $companyBusinessUnitFacade
    ) {
        $this->repository = $repository;
        $this->companyBusinessUnitFacade = $companyBusinessUnitFacade;
    }

    /**
     * @param string $companyUserReference
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitTransfer|null
     */
    public function getByCompanyUserReference(string $companyUserReference): ?CompanyBusinessUnitTransfer
    {
        $idCompanyBusinessUnit = $this->repository->findIdCompanyBusinessUnitByCompanyUserReference(
            $companyUserReference,
        );

        if ($idCompanyBusinessUnit === null) {
            return null;
        }

        return $this->companyBusinessUnitFacade->findCompanyBusinessUnitById($idCompanyBusinessUnit);
    }
}
