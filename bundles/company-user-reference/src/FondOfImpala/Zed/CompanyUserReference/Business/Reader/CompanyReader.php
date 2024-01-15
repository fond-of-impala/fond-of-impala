<?php

namespace FondOfImpala\Zed\CompanyUserReference\Business\Reader;

use FondOfImpala\Zed\CompanyUserReference\Dependency\Facade\CompanyUserReferenceToCompanyFacadeInterface;
use FondOfImpala\Zed\CompanyUserReference\Persistence\CompanyUserReferenceRepositoryInterface;
use Generated\Shared\Transfer\CompanyTransfer;

class CompanyReader implements CompanyReaderInterface
{
    /**
     * @var \FondOfImpala\Zed\CompanyUserReference\Persistence\CompanyUserReferenceRepositoryInterface
     */
    protected $repository;

    /**
     * @var \FondOfImpala\Zed\CompanyUserReference\Dependency\Facade\CompanyUserReferenceToCompanyFacadeInterface
     */
    protected $companyFacade;

    /**
     * @param \FondOfImpala\Zed\CompanyUserReference\Persistence\CompanyUserReferenceRepositoryInterface $repository
     * @param \FondOfImpala\Zed\CompanyUserReference\Dependency\Facade\CompanyUserReferenceToCompanyFacadeInterface $companyFacade
     */
    public function __construct(
        CompanyUserReferenceRepositoryInterface $repository,
        CompanyUserReferenceToCompanyFacadeInterface $companyFacade
    ) {
        $this->repository = $repository;
        $this->companyFacade = $companyFacade;
    }

    /**
     * @param string $companyUserReference
     *
     * @return \Generated\Shared\Transfer\CompanyTransfer|null
     */
    public function getByCompanyUserReference(string $companyUserReference): ?CompanyTransfer
    {
        $idCompany = $this->repository->findIdCompanyByCompanyUserReference($companyUserReference);

        if ($idCompany === null) {
            return null;
        }

        return $this->companyFacade->findCompanyById($idCompany);
    }
}
