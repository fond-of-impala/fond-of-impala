<?php

namespace FondOfImpala\Zed\CompanyUserCompanyAssigner\Dependency\Facade;

use FondOfImpala\Zed\CompanyType\Business\CompanyTypeFacadeInterface;
use Generated\Shared\Transfer\CompanyCollectionTransfer;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyTypeCollectionTransfer;
use Generated\Shared\Transfer\CompanyTypeResponseTransfer;
use Generated\Shared\Transfer\CompanyTypeTransfer;

class CompanyUserCompanyAssignerToCompanyTypeFacadeBridge implements CompanyUserCompanyAssignerToCompanyTypeFacadeInterface
{
    /**
     * @var \FondOfImpala\Zed\CompanyType\Business\CompanyTypeFacadeInterface
     */
    protected $companyTypeFacade;

    /**
     * @param \FondOfImpala\Zed\CompanyType\Business\CompanyTypeFacadeInterface $companyTypeFacade
     */
    public function __construct(CompanyTypeFacadeInterface $companyTypeFacade)
    {
        $this->companyTypeFacade = $companyTypeFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTypeTransfer $companyTypeTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTypeResponseTransfer
     */
    public function findCompanyTypeById(CompanyTypeTransfer $companyTypeTransfer): CompanyTypeResponseTransfer
    {
        return $this->companyTypeFacade->findCompanyTypeById($companyTypeTransfer);
    }

    /**
     * @return \Generated\Shared\Transfer\CompanyTypeCollectionTransfer
     */
    public function getCompanyTypes(): CompanyTypeCollectionTransfer
    {
        return $this->companyTypeFacade->getCompanyTypes();
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTypeCollectionTransfer $companyTypeCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyCollectionTransfer|null
     */
    public function findCompaniesByCompanyTypeIds(
        CompanyTypeCollectionTransfer $companyTypeCollectionTransfer
    ): ?CompanyCollectionTransfer {
        return $this->companyTypeFacade->findCompaniesByCompanyTypeIds($companyTypeCollectionTransfer);
    }

    /**
     * @return string|null
     */
    public function getCompanyTypeManufacturerName(): ?string
    {
        return $this->companyTypeFacade->getCompanyTypeManufacturerName();
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTypeTransfer $companyTypeTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTypeTransfer|null
     */
    public function getCompanyTypeByName(CompanyTypeTransfer $companyTypeTransfer): ?CompanyTypeTransfer
    {
        return $this->companyTypeFacade->getCompanyTypeByName($companyTypeTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTypeTransfer $companyTypeTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTypeTransfer|null
     */
    public function getCompanyTypeById(CompanyTypeTransfer $companyTypeTransfer): ?CompanyTypeTransfer
    {
        return $this->companyTypeFacade->getCompanyTypeById($companyTypeTransfer);
    }

    /**
     * @return \Generated\Shared\Transfer\CompanyTypeTransfer|null
     */
    public function getManufacturerCompanyType(): ?CompanyTypeTransfer
    {
        return $this->companyTypeFacade->getCompanyTypeManufacturer();
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTypeTransfer|null
     */
    public function findCompanyTypeByIdCompany(CompanyTransfer $companyTransfer): ?CompanyTypeTransfer
    {
        return $this->companyTypeFacade->findCompanyTypeByIdCompany($companyTransfer);
    }
}
