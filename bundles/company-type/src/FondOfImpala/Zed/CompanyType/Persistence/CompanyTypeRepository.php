<?php

namespace FondOfImpala\Zed\CompanyType\Persistence;

use Generated\Shared\Transfer\CompanyCollectionTransfer;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyTypeCollectionTransfer;
use Generated\Shared\Transfer\CompanyTypeTransfer;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \FondOfImpala\Zed\CompanyType\Persistence\CompanyTypePersistenceFactory getFactory()
 */
class CompanyTypeRepository extends AbstractRepository implements CompanyTypeRepositoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param int $idCompanyType
     *
     * @return \Generated\Shared\Transfer\CompanyTypeTransfer|null
     */
    public function getById(int $idCompanyType): ?CompanyTypeTransfer
    {
        $fosCompanyType = $this->getFactory()
            ->createCompanyTypeQuery()
            ->filterByIdCompanyType($idCompanyType)
            ->findOne();

        if ($fosCompanyType === null) {
            return null;
        }

        return $this->getFactory()
            ->createCompanyTypeMapper()
            ->mapEntityToTransfer($fosCompanyType, new CompanyTypeTransfer());
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param string $name
     *
     * @return \Generated\Shared\Transfer\CompanyTypeTransfer|null
     */
    public function getByName(string $name): ?CompanyTypeTransfer
    {
        $fosCompanyType = $this->getFactory()
            ->createCompanyTypeQuery()
            ->filterByName($name)
            ->findOne();

        if ($fosCompanyType === null) {
            return null;
        }

        return $this->getFactory()
            ->createCompanyTypeMapper()
            ->mapEntityToTransfer($fosCompanyType, new CompanyTypeTransfer());
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return \Generated\Shared\Transfer\CompanyTypeCollectionTransfer
     */
    public function getAll(): CompanyTypeCollectionTransfer
    {
        $fosCompanyTypes = $this->buildQueryFromCriteria(
            $this->getFactory()->createCompanyTypeQuery(),
        )->find();

        $companyTypeMapper = $this->getFactory()->createCompanyTypeMapper();

        $companyTypeCollectionTransfer = new CompanyTypeCollectionTransfer();

        foreach ($fosCompanyTypes as $fosCompanyType) {
            $companyTypeTransfer = $companyTypeMapper->mapEntityTransferToTransfer($fosCompanyType, new CompanyTypeTransfer());
            $companyTypeCollectionTransfer->addCompanyType($companyTypeTransfer);
        }

        return $companyTypeCollectionTransfer;
    }

    /**
     * Specification:
     * - Returns a Companies by Company Type Ids
     *
     * @api
     *
     * @param array $companyTypeIds
     *
     * @return \Generated\Shared\Transfer\CompanyCollectionTransfer|null
     */
    public function findCompaniesByCompanyTypeIds(array $companyTypeIds): ?CompanyCollectionTransfer
    {
        $companyCollection = $this->getFactory()
            ->createCompanyQuery()
            ->filterByFkCompanyType_In($companyTypeIds)
            ->find();

        if ($companyCollection->count() === 0) {
            return null;
        }

        $companyMapper = $this->getFactory()->createCompanyMapper();
        $companyCollectionTransfer = new CompanyCollectionTransfer();

        foreach ($companyCollection as $companyEntity) {
            $companyTransfer = $companyMapper->mapEntityToTransfer($companyEntity, new CompanyTransfer());
            $companyCollectionTransfer->addCompany($companyTransfer);
        }

        return $companyCollectionTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTypeTransfer|null
     */
    public function findCompanyTypeByIdCompany(CompanyTransfer $companyTransfer): ?CompanyTypeTransfer
    {
        $companyEntity = $this->getFactory()
            ->createCompanyQuery()
            ->filterByIdCompany($companyTransfer->getIdCompany())
            ->findOne();

        if ($companyEntity === null) {
            return null;
        }

        return $this->getById($companyEntity->getFkCompanyType());
    }
}
