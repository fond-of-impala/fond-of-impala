<?php

namespace FondOfImpala\Zed\CompanyType\Business\Model;

use FondOfImpala\Zed\CompanyType\CompanyTypeConfig;
use FondOfImpala\Zed\CompanyType\Persistence\CompanyTypeRepositoryInterface;
use Generated\Shared\Transfer\CompanyCollectionTransfer;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyTypeCollectionTransfer;
use Generated\Shared\Transfer\CompanyTypeResponseTransfer;
use Generated\Shared\Transfer\CompanyTypeTransfer;

class CompanyTypeReader implements CompanyTypeReaderInterface
{
    protected CompanyTypeConfig $companyTypeConfig;

    protected CompanyTypeRepositoryInterface $companyTypeRepository;

    /**
     * @param \FondOfImpala\Zed\CompanyType\Persistence\CompanyTypeRepositoryInterface $companyTypeRepository
     * @param \FondOfImpala\Zed\CompanyType\CompanyTypeConfig $companyTypeConfig
     */
    public function __construct(
        CompanyTypeRepositoryInterface $companyTypeRepository,
        CompanyTypeConfig $companyTypeConfig
    ) {
        $this->companyTypeRepository = $companyTypeRepository;
        $this->companyTypeConfig = $companyTypeConfig;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTypeTransfer $companyTypeTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTypeTransfer|null
     */
    public function getById(CompanyTypeTransfer $companyTypeTransfer): ?CompanyTypeTransfer
    {
        $companyTypeTransfer->requireIdCompanyType();

        return $this->companyTypeRepository->getById($companyTypeTransfer->getIdCompanyType());
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTypeTransfer $companyTypeTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTypeTransfer|null
     */
    public function getByName(CompanyTypeTransfer $companyTypeTransfer): ?CompanyTypeTransfer
    {
        $companyTypeTransfer->requireName();

        return $this->companyTypeRepository->getByName($companyTypeTransfer->getName());
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTypeCollectionTransfer $companyTypeCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyCollectionTransfer|null
     */
    public function findCompaniesByCompanyTypeIds(CompanyTypeCollectionTransfer $companyTypeCollectionTransfer): ?CompanyCollectionTransfer
    {
        $companyTypeIds = [];

        foreach ($companyTypeCollectionTransfer->getCompanyTypes() as $companyTypeTransfer) {
            $companyTypeIds[] = $companyTypeTransfer->getIdCompanyType();
        }

        return $this->companyTypeRepository->findCompaniesByCompanyTypeIds($companyTypeIds);
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTypeTransfer|null
     */
    public function findCompanyTypeByIdCompany(CompanyTransfer $companyTransfer): ?CompanyTypeTransfer
    {
        return $this->companyTypeRepository->findCompanyTypeByIdCompany($companyTransfer);
    }

    /**
     * @return \Generated\Shared\Transfer\CompanyTypeCollectionTransfer
     */
    public function getAll(): CompanyTypeCollectionTransfer
    {
        return $this->companyTypeRepository->getAll();
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTypeTransfer $companyTypeTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTypeResponseTransfer
     */
    public function findCompanyTypeById(CompanyTypeTransfer $companyTypeTransfer): CompanyTypeResponseTransfer
    {
        $companyTypeTransfer->requireIdCompanyType();

        $companyTypeTransfer = $this->companyTypeRepository->getById($companyTypeTransfer->getIdCompanyType());

        $companyTypeResponseTransfer = new CompanyTypeResponseTransfer();
        if ($companyTypeTransfer === null) {
            return $companyTypeResponseTransfer->setIsSuccessful(false);
        }

        return $companyTypeResponseTransfer
            ->setIsSuccessful(true)
            ->setCompanyTypeTransfer($companyTypeTransfer);
    }

    /**
     * @return \Generated\Shared\Transfer\CompanyTypeTransfer|null
     */
    public function getCompanyTypeManufacturer(): ?CompanyTypeTransfer
    {
        $name = $this->companyTypeConfig->getCompanyTypeManufacturer();

        if (!$name) {
            return null;
        }

        return $this->companyTypeRepository->getByName($name);
    }
}
