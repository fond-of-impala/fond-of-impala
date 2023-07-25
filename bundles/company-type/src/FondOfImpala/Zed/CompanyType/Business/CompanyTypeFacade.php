<?php

namespace FondOfImpala\Zed\CompanyType\Business;

use Generated\Shared\Transfer\CompanyCollectionTransfer;
use Generated\Shared\Transfer\CompanyResponseTransfer;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyTypeCollectionTransfer;
use Generated\Shared\Transfer\CompanyTypeResponseTransfer;
use Generated\Shared\Transfer\CompanyTypeTransfer;
use Generated\Shared\Transfer\EventEntityTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfImpala\Zed\CompanyType\Business\CompanyTypeBusinessFactory getFactory()
 * @method \FondOfImpala\Zed\CompanyType\Persistence\CompanyTypeEntityManagerInterface getEntityManager()
 * @method \FondOfImpala\Zed\CompanyType\Persistence\CompanyTypeRepositoryInterface getRepository()
 */
class CompanyTypeFacade extends AbstractFacade implements CompanyTypeFacadeInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CompanyTypeTransfer $companyTypeTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTypeTransfer|null
     */
    public function getCompanyTypeById(CompanyTypeTransfer $companyTypeTransfer): ?CompanyTypeTransfer
    {
        return $this->getFactory()->createCompanyTypeReader()->getById($companyTypeTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return \Generated\Shared\Transfer\CompanyTypeCollectionTransfer
     */
    public function getCompanyTypes(): CompanyTypeCollectionTransfer
    {
        return $this->getFactory()->createCompanyTypeReader()->getAll();
    }

    /**
     * {@inheritDoc}
     *
     * @param \Generated\Shared\Transfer\CompanyTypeTransfer $companyTypeTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTypeTransfer
     */
    public function createCompanyType(CompanyTypeTransfer $companyTypeTransfer): CompanyTypeTransfer
    {
        return $this->getFactory()->createCompanyTypeWriter()->create($companyTypeTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @param \Generated\Shared\Transfer\CompanyTypeTransfer $companyTypeTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTypeTransfer
     */
    public function updateCompanyType(CompanyTypeTransfer $companyTypeTransfer): CompanyTypeTransfer
    {
        return $this->getFactory()->createCompanyTypeWriter()->update($companyTypeTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CompanyTypeTransfer $companyTypeTransfer
     *
     * @return void
     */
    public function deleteCompanyType(CompanyTypeTransfer $companyTypeTransfer): void
    {
        $this->getFactory()->createCompanyTypeWriter()->deleteById($companyTypeTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CompanyTypeTransfer $companyTypeTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTypeResponseTransfer
     */
    public function findCompanyTypeById(CompanyTypeTransfer $companyTypeTransfer): CompanyTypeResponseTransfer
    {
        return $this->getFactory()->createCompanyTypeReader()->findCompanyTypeById($companyTypeTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTypeTransfer|null
     */
    public function findCompanyTypeByIdCompany(CompanyTransfer $companyTransfer): ?CompanyTypeTransfer
    {
        return $this->getFactory()->createCompanyTypeReader()->findCompanyTypeByIdCompany($companyTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @param \Generated\Shared\Transfer\CompanyTypeCollectionTransfer $companyTypeCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyCollectionTransfer|null
     */
    public function findCompaniesByCompanyTypeIds(CompanyTypeCollectionTransfer $companyTypeCollectionTransfer): ?CompanyCollectionTransfer
    {
        return $this->getFactory()->createCompanyTypeReader()->findCompaniesByCompanyTypeIds($companyTypeCollectionTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @param \Generated\Shared\Transfer\CompanyTypeTransfer $companyTypeTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTypeTransfer|null
     */
    public function getCompanyTypeByName(CompanyTypeTransfer $companyTypeTransfer): ?CompanyTypeTransfer
    {
        return $this->getFactory()->createCompanyTypeReader()->getByName($companyTypeTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyResponseTransfer $companyResponseTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyResponseTransfer
     */
    public function assignDefaultCompanyTypeToNewCompany(CompanyResponseTransfer $companyResponseTransfer): CompanyResponseTransfer
    {
        return $this->getFactory()
            ->createCompanyTypeAssigner()
            ->assignDefaultCompanyTypeToNewCompany($companyResponseTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return string|null
     */
    public function getCompanyTypeManufacturerName(): ?string
    {
        return $this->getFactory()->getConfig()->getCompanyTypeManufacturer();
    }

    /**
     * @return \Generated\Shared\Transfer\CompanyTypeTransfer|null
     */
    public function getCompanyTypeManufacturer(): ?CompanyTypeTransfer
    {
        return $this->getFactory()
            ->createCompanyTypeReader()
            ->getCompanyTypeManufacturer();
    }

    /**
     * @param \Generated\Shared\Transfer\EventEntityTransfer $transfer
     *
     * @return bool
     */
    public function validateCompanyTypeForExport(EventEntityTransfer $transfer): bool
    {
        return $this->getFactory()
            ->createCompanyTypeExportValidator()
            ->validate($transfer);
    }
}
